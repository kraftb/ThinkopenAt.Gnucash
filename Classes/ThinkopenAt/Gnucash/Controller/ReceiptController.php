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

class ReceiptController extends ActionController {

    /**
     * @Flow\Inject
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

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
	public function newAction() {
	}

}

