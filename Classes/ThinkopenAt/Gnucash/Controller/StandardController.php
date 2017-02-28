<?php
namespace ThinkopenAt\Gnucash\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.TimeFlies". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Utility\Arrays;

use ThinkopenAt\Gnucash\Domain\Model\Account;

class StandardController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\AccountRepository
	 */
	protected $accountRepository = NULL;

	/**
	 * @Flow\Inject
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\SplitRepository
	 */
	protected $splitRepository = NULL;

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
	 * @var array
	 * @Flow\Inject(setting="Setup")
	 */
	protected $settings;

	/**
	 * Setter for injected settings.
	 *
	 * @param array $settings
	 * @return void
	 */
	public function setSettings(array $settings) {
		$this->settings = $settings;
	}

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
        $year = 2016;
        $quarter = 3;
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

        $this->view->assign('now', new \DateTime());
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
     * Determine the DateTime for the start of a quarter
     *
     * @param integer $year: The year for which to determine the quarter start
     * @param integer $quarter: The quarter (1-4) for which to determine the start
     * @return \DateTime The quarter start
     */
    protected function getQuarterStart($year, $quarter) {
        $month = (($quarter - 1) * 3) + 1;
        return new \DateTime($year.'-'.$month.'-1 0:00');
    }

    /**
     * Determine the DateTime for the end of a quarter
     *
     * @param integer $year: The year for which to determine the quarter end
     * @param integer $quarter: The quarter (1-4) for which to determine the end
     * @return \DateTime The quarter end
     */
    protected function getQuarterEnd($year, $quarter) {
        $month = ($quarter * 3) + 1;
        if ($month > 12) {
            $month -= 12;
            $year += 1;
        }
        return new \DateTime($year.'-'.$month.'-1 0:00');
    }

	/**
	 * @return void
	 */
	public function billCustomerAction() {
        $this->view->assign('now', new \DateTime());
        $this->view->assign('customerOptions', $this->getCustomerOptions());
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
            $result[$customer->getIdentifier()] = $customer;
        }
        return $result;
    }

	/**
     * Handler action for creating a new bill handling the posted $newBill data.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\Bill $newBill: New bill which to create
	 * @return void
	 */
	public function createBillAction(\ThinkopenAt\Gnucash\Domain\Dto\Bill $newBill) {
var_dump($newBill);
exit();
	}

}

