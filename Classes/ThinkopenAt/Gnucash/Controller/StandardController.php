<?php
namespace ThinkopenAt\Gnucash\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.TimeFlies". *
 *                                                                        *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Utility\Arrays;

use ThinkopenAt\Gnucash\Domain\Model\Account;
use ThinkopenAt\Gnucash\Domain\Type\Fraction;

class StandardController extends AbstractGnucashController {

    /**
     * @Flow\Inject
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;


	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\TransactionRepository
	 */
	protected $transactionRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\CustomerRepository
	 */
	protected $customerRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\CurrencyRepository
	 */
	protected $currencyRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\InvoiceRepository
	 */
	protected $invoiceRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\InvoiceEntryRepository
	 */
	protected $invoiceEntryRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\LotRepository
	 */
	protected $lotRepository = NULL;

	/**
	 * @var array
	 * @Flow\Inject(setting="Setup")
	 */
	protected $settings;

	/**
     * A newly created invoice
     *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Invoice
	 */
	protected $newInvoice = NULL;

	/**
     * An instance-local cache to keep newly generated UIDs so no conflicts arise.
     *
	 * @var array
	 */
	protected $newUidCache = array();


	/**
	 * @return void
	 */
	public function indexAction() {
	}

	/**
	 * @return void
	 */
	public function vatDeclarationXmlAction() {
        $this->controllerContext->getResponse()->setHeader('Content-Type', 'text/xml');
        return $this->vatDeclarationAction();
	}

	/**
	 * @return void
	 */
	public function salesListXmlAction() {
        $this->controllerContext->getResponse()->setHeader('Content-Type', 'text/xml');
        return $this->vatDeclarationAction();
    }

	/**
	 * @return void
	 */
	public function vatDeclarationAction() {
        $year = 2017;
        $quarter = 1;
        $company = $this->settings['Setup']['CompanyName'];
        $taxId = $this->settings['Setup']['TaxId'];

        if (!($year && $quarter)) {
            throw new \Exception('Year and quarter of the report have to get passed.');
        }

        $accountsIncomeAt = $this->accountRepository->findChildrenByCode('VAT-INCOME-AT');
        $accountsIncomeEu = $this->accountRepository->findChildrenByCode('VAT-INCOME-EU');
        $accountsIncomeWw = $this->accountRepository->findChildrenByCode('VAT-INCOME-WW');
        $accountsVat20 = $this->accountRepository->findByCode('VAT-RETURN-20');
        $accountsVat10 = $this->accountRepository->findByCode('VAT-RETURN-10');
        $accountsVatEu = $this->accountRepository->findByCode('VAT-RETURN-EU');
        $accountsPurchaseEu = $this->accountRepository->findByCode('PURCHASE-EU');
        $accountsVatAt = $this->accountRepository->findByCode('VAT-AT');

        $begin = $this->getQuarterStart($year, $quarter);
        $end = $this->getQuarterEnd($year, $quarter);

        $splitsIncomeAt = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeAt);
        $splitsIncomeEu = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeEu);
        $splitsIncomeWw = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsIncomeWw);
        $splitsVat20 = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsVat20);
        $splitsVat10 = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsVat10);
        $splitsVatEu = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsVatEu);
        $splitsVatAt = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsVatAt);
        $splitsPurchaseEu = $this->splitRepository->findByPostDateRangeAndAccount($begin, $end, $accountsPurchaseEu);

        $this->view->assign('incomeAt', $splitsIncomeAt);
        $this->view->assign('incomeEu', $splitsIncomeEu);
        $this->view->assign('incomeWw', $splitsIncomeWw);
        $this->view->assign('vat20', $splitsVat20);
        $this->view->assign('vat10', $splitsVat10);
        $this->view->assign('vatEu', $splitsVatEu);
        $this->view->assign('vatAt', $splitsVatAt);
        $this->view->assign('purchaseEu', $splitsPurchaseEu);

        if (count($splitsIncomeEu)) {
            $this->view->assign('ZusammenfassendeMeldung', true);
        }

        $this->view->assign('now', new \TYPO3\Flow\Utility\Now());
        $this->view->assign('begin', $begin);
        $this->view->assign('end', $end);
        $this->view->assign('endQuarter', $end->modify('-1 day'));
        $this->view->assign('year', $year);
        $this->view->assign('quarter', $quarter);
        $this->view->assign('company', $company);
        $this->view->assign('tax-id-orig', $taxId);
        $this->view->assign('tax-id', preg_replace('/[^0-9]/', '', $taxId));
        $taxData = array(
            $begin,
            $end,
            $company,
            $splitsIncomeAt->toArray(),
            $splitsIncomeEu->toArray(),
            $splitsIncomeWw->toArray()
        );
        $dataHash = hexdec(substr(sha1(serialize($taxData)), 0, 6)) % 1000000000;
        $this->view->assign('data-hash', $dataHash);
    }

	/**
	 * @return void
	 */
	public function billCustomerAction() {
        $this->view->assign('now', new \TYPO3\Flow\Utility\Now());
        $this->view->assign('customerOptions', $this->getCustomerOptions());
        $this->view->assign('newInvoice', $this->newInvoice);
	}

	/**
     * Returns options of available customers
     *
	 * @return array All available customers
	 */
    protected function getCustomerOptions() {
        $customers = $this->customerRepository->findAll();
        $result = array();
        foreach ($customers as $customer) {
            $result[(string)$customer] = $customer->getId() . ': ' . $customer->getName();
        }
        return $result;
    }

	/**
     * Initialize method for "createBill" action
     *
	 * @return void
	 */
	public function initializeCreateBillAction() {
        $newBill = $this->request->getArgument('newBill');
        unset($newBill['entries']['*']);
        $this->request->setArgument('newBill', $newBill);
    }

	/**
     * Handler action for creating a new bill handling the posted $newBill data.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\Bill $newBill: New bill which to create
	 * @return void
	 */
	public function createBillAction(\ThinkopenAt\Gnucash\Domain\Dto\Bill $newBill) {
        $sums = $this->getBillSums($newBill);
        
        $invoice = $newBill->getInvoice();
        $this->prepareInvoiceForPersisting($invoice, $sums);

        $invoiceEntries = $this->getInvoiceEntries($newBill);
        $invoice->setEntries($invoiceEntries);

        $serviceBegin = $newBill->getServiceBegin();
        $serviceEnd = $newBill->getServiceEnd();

        $notes = 'LZ:' . $serviceBegin->format('Y-m-d') . '|' . $serviceEnd->format('Y-m-d');
        $invoice->setNotes($notes);

        $this->persistInvoice($invoice);

        $this->newInvoice = $this->invoiceRepository->findByIdentifier((string)$invoice);

        $this->forward('billCustomer');
	}

	/**
     * Persist the given invoice, the transaction and splits within it and the
     * generated invoice entries.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: Persist it
	 * @return void
	 */
    protected function persistInvoice(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        // Make persisting transactional.
        // If someone has allocated UIDs in the meantime there will be a PRIMARY-KEY
        // conflict and the "commit" will not happen.
        $this->entityManager->beginTransaction();
        $this->invoiceRepository->add($invoice);
        $this->persistenceManager->persistAll();
        $this->entityManager->commit();
    }

	/**
     * Retrieve invoice entries
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\Bill $bill: Bill from which to take entries
	 * @return Collection<\ThinkopenAt\Gnucash\Domain\Model\InvoiceEntry> The invoice entries
	 */
    protected function getInvoiceEntries(\ThinkopenAt\Gnucash\Domain\Dto\Bill $bill) {
        $entries = $bill->getEntries();
        $result = $this->objectManager->get(ArrayCollection::class);

        foreach ($entries as $entry) {
            $entry->setBill($bill);
            $invoiceEntry = $this->getInvoiceEntry($entry);
            $result->add($invoiceEntry);
        }

        return $result;
    }

    /**
     * Generate an invoice entry for the given bill entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\BillEntry $entry: Bill entry base for invoice entry
     * @return \ThinkopenAt\Gnucash\Domain\Model\InvoiceEntry Generated invoice entry
     */
    protected function getInvoiceEntry(\ThinkopenAt\Gnucash\Domain\Dto\BillEntry $entry) {
        $bill = $entry->getBill();
        $invoice = $bill->getInvoice();
        $invoiceEntry = $this->objectManager->get(\ThinkopenAt\Gnucash\Domain\Model\InvoiceEntry::class);

        $newUid = $this->getNewUid($this->invoiceEntryRepository);
        $invoiceEntry->setPersistenceObjectIdentifier($newUid);

        // Set: date_post
        $postDate = $invoice->getPosted();
        $invoiceEntry->setDate($postDate);

        // Set: date_entered
        $invoiceEntry->setEntered(new \TYPO3\Flow\Utility\Now());

        // Set: description
        $description = $entry->getDescription();
        $description = str_replace("\n", ';;', $description);
        $invoiceEntry->setDescription($description);

        // Set: action
        $action = $entry->getAction();
        if ($action === 'empty') {
            $action = '';
        }
        $invoiceEntry->setAction($action);

        // Set: quantity
        $quantity = $this->objectManager->get(Fraction::class, $entry->getQuantity());
        $invoiceEntry->setQuantity($quantity);

        // Set: account
        $accountIncome = $this->getIncomeAccountForInvoice($invoice);
        $invoiceEntry->setAccount($accountIncome);

        // Set: price
        $price = $this->objectManager->get(Fraction::class, $entry->getPrice());
        $invoiceEntry->setPrice($price);

        // Set: discount
        $discount = $this->objectManager->get(Fraction::class);
        $invoiceEntry->setDiscount($discount);

        // Set: misc properties
        $invoiceEntry->setInvoice($invoice);
        $invoiceEntry->setDiscountType('PERCENT');
        $invoiceEntry->setDiscountOrder('PRETAX');
        $invoiceEntry->setTaxable(true);
        $invoiceEntry->setTaxIncluded(false);
        
        // Set: taxtable
        $owner = $this->getInvoiceOwner($invoice);
        $taxTable = $owner->getTaxTable();
        if (! $taxTable instanceof \ThinkopenAt\Gnucash\Domain\Model\TaxTable) {
            throw new \Exception('No tax table set for owner/customer!');
        }
        $invoiceEntry->setTaxTable($taxTable);

        return $invoiceEntry;
    }

    /**
     * Return owner/customer of given invoice with existance-check
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice from which to retrieve customer/owner
     * @return \ThinkopenAt\Gnucash\Domain\Model\Customer The customer/owner of the given invoice
     */
    protected function getInvoiceOwner(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $owner = $invoice->getOwner();
        if (! $owner instanceof \ThinkopenAt\Gnucash\Domain\Model\Customer) {
            throw new \Exception('No owner/customer set for invoice!');
        }
        return $owner;
    }

	/**
     * Retrieve bill entries and calculate total, net and VAT sums
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\Bill $bill: Bill from which to take entries
	 * @return array An array with keys "net", "total" and "vat"
	 */
    protected function getBillSums(\ThinkopenAt\Gnucash\Domain\Dto\Bill $bill) {
        $entries = $bill->getEntries();

        $net = $this->objectManager->get(Fraction::class, 0, 0);
        foreach ($entries as $entry) {
            $entryNet = $entry->getNet();
            $entryFraction = $this->objectManager->get(Fraction::class, $entryNet);
            $net->add($entryFraction);
        }

        $vatF = $net->toFloat();
        $vatF *= 0.20;
        $vatF = round($vatF, 2);

        $vat = $this->objectManager->get(Fraction::class, (string)$vatF);
        $total = clone($net);
        $total->add($vat);

        $sums = array(
            'net' => $net,
            'vat' => $vat,
            'total' => $total,
        );

        return $sums;
    }

    /**
     * Creates a sane state for the invoice so it can get persisted properly.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice to clean up
     * @param array $sums: The sums "net", "vat" and "total" of the invoice
     * @return void
     */
    protected function prepareInvoiceForPersisting(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice, array $sums) {
        $newUid = $this->getNewUid($this->invoiceRepository);
        $invoice->setPersistenceObjectIdentifier($newUid);

        $invoice->setPosted($invoice->getOpened());

        $invoice->setActive(true);

        // Get currency which to use from settings and retrieve
        // from currencyRepository
        $currencyShort = $this->settings['Setup']['Currency'];
        $currencies = $this->currencyRepository->findByMnemonic($currencyShort);
        if (count($currencies) > 1) {
            throw new \Exception('More than once currency matches the given code!');
        }
        if (count($currencies) == 0) {
            throw new \Exception('No currency matches the given code!');
        }
        $currency = $currencies->getFirst();
        $invoice->setCurrency($currency);

        $invoice->setOwnerType(2);

        $owner = $this->getInvoiceOwner($invoice);
        $invoice->setTerms($owner->getTerms());

        $invoice->setBilltoType(2);

        $chargeAmount = $this->objectManager->get(Fraction::class, 0, 1);
        $invoice->setChargeAmount($chargeAmount);

        $lot = $this->generateInvoiceLot($invoice);
        $invoice->setLot($lot);
        $invoice->setAccount($lot->getAccount());

        $transaction = $this->generateInvoiceTransaction($invoice);
        $invoice->setTransaction($transaction);

        $splits = $this->generateInvoiceSplits($invoice, $sums);
        $transaction->setSplits($splits);

        return $invoice;
    }

    /**
     * Generate a new uid in the given repository
     *
     * @param \TYPO3\Flow\Persistence\Repository $repository: The repository for which to generate a new persistence object identifier
     * @return string A new unique persistence object identifier
     */
    protected function getNewUid($repository) {
        $index = 100;
        $entity = $repository->getEntityClassName();
        do {
            $newUid = md5(time() . '|' . getmypid() . '|' . rand(1, 0xffffffff));
            $count = $repository->countByIdentifier($newUid);
            if (!--$index) {
                throw new \Exception('No way to generate a new unique identifier.');
            }
            if (isset($this->newUidCache[$entity][$newUid])) {
                $count++;
            }
        } while ($count > 0);
        $this->newUidCache[$entity][$newUid] = true;
        return $newUid;
    }

    /**
     * Generate the lot for the given invoice
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for which to generate the lot entry
     * @return \ThinkopenAt\Gnucash\Domain\Model\Lot The generated lot entry
     */
    protected function generateInvoiceLot(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $lot = $this->objectManager->get(\ThinkopenAt\Gnucash\Domain\Model\Lot::class);

        $newUid = $this->getNewUid($this->lotRepository);
        $lot->setPersistenceObjectIdentifier($newUid);

        $currencyShort = $invoice->getCurrency()->getMnemonic();
        $lotAccounts = $this->accountRepository->findByCode('POST-INVOICE:' . $currencyShort);

        if (count($lotAccounts) > 1) {
            throw new \Exception('More than account matches the given post-invoice code!');
        }
        if (count($lotAccounts) == 0) {
            throw new \Exception('No account matches the given post-invoice code!');
        }

        $lotAccount = $lotAccounts->getFirst();
        $lot->setAccount($lotAccount);
        $lot->setIsClosed(-1);

        return $lot;
    }

    /**
     * Generate the invoice domain model object for the passed invoice
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for which to generate the transaction
     * @return \ThinkopenAt\Gnucash\Domain\Model\Transaction The generated transaction
     */
    protected function generateInvoiceTransaction(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $transaction = $this->objectManager->get(\ThinkopenAt\Gnucash\Domain\Model\Transaction::class);

        $newUid = $this->getNewUid($this->transactionRepository);
        $transaction->setPersistenceObjectIdentifier($newUid);

        $owner = $this->getInvoiceOwner($invoice);

        $transaction->setCurrency($invoice->getCurrency());
        $transaction->setNumber($invoice->getId());
        $transaction->setPostDate($invoice->getOpened());
        $transaction->setEnterDate(new \TYPO3\Flow\Utility\Now());
        $transaction->setDescription($owner->getName());

        return $transaction;
    }

    /**
     * Generate the transaction splits for the given invoice.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for which to generate a split 
     * @param array $sums: The sums "net", "vat" and "total" of the invoice
     * @return \ThinkopenAt\Gnucash\Domain\Model\Split The generated split
     */
    protected function generateInvoiceSplits(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice, array $sums) {
        $accountIncome = $this->getIncomeAccountForInvoice($invoice);

        $accountVat = $this->accountRepository->findByCode('VAT-AT');
        if (count($accountVat) !== 1) {
            throw new \Exception('Only one account must have code "VAT-AT" set!');
        }
        $accountVat = $accountVat->getFirst();

        $splitPost = $this->generateInvoiceSplitBase($invoice);
        $splitPost->setAccount($invoice->getAccount());
        $splitPost->setLot($invoice->getLot());
        $splitPost->setValue($sums['total']);
        $splitPost->setQuantity($sums['total']);

        $splitIncome = $this->generateInvoiceSplitBase($invoice);
        $splitIncome->setAccount($accountIncome);
        $splitIncome->setValue($sums['net']);
        $splitIncome->setQuantity($sums['net']);

        $splitVat = $this->generateInvoiceSplitBase($invoice);
        $splitVat->setAccount($accountVat);
        $splitVat->setValue($sums['vat']);
        $splitVat->setQuantity($sums['vat']);

        $splits = $this->objectManager->get(ArrayCollection::class);
        $splits->add($splitPost);
        $splits->add($splitIncome);
        $splits->add($splitVat);

        return $splits;
    }

    /**
     * Retrieve the proper income account for the given invoice
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for which to retrieve income account
     * @return \ThinkopenAt\Gnucash\Domain\Model\Account The income account for the passed invoice
     */
    protected function getIncomeAccountForInvoice(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $owner = $this->getInvoiceOwner($invoice);

        $ownerId = $owner->getId();
        if (strlen($ownerId) !== 3) {
            throw new \Exception('Owner/customer ids have to be 3 characters long!');
        }

        $accountIncome = $this->accountRepository->findByCode('CUSTOMER:' . $ownerId);
        if (count($accountIncome) !== 1) {
            throw new \Exception('Only one account must have code "CUSTOMER:' . $ownerId . '" set!');
        }
        return $accountIncome->getFirst();
    }

    /**
     * Generate a basic split instance which is to be used as common base for
     * invoice transaction splits.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for which to generate a split 
     * @return \ThinkopenAt\Gnucash\Domain\Model\Split The generated split
     */
    protected function generateInvoiceSplitBase(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $split = $this->objectManager->get(\ThinkopenAt\Gnucash\Domain\Model\Split::class);

        $newUid = $this->getNewUid($this->splitRepository);
        $split->setPersistenceObjectIdentifier($newUid);

        $split->setTransaction($invoice->getTransaction());
        $split->setAction('invoice');
        $split->setReconcileState('n');
        return $split;
    }

}

