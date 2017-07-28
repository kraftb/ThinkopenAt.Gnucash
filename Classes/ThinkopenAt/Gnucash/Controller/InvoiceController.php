<?php
namespace ThinkopenAt\Gnucash\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Utility\Arrays;

use ThinkopenAt\Gnucash\Domain\Model\Account;
use ThinkopenAt\Gnucash\Domain\Type\Fraction;

class InvoiceController extends ActionController {

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
	 * @var \ThinkopenAt\Gnucash\Domain\Repository\VendorRepository
	 */
	protected $vendorRepository = NULL;

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
	public function newReceiptAction() {
        $this->view->assign('now', new \TYPO3\Flow\Utility\Now());
        $vendors = $this->vendorRepository->findAll();
        $this->view->assign('vendors', $vendors);
	}

    /**
     * Initializes the "createReceipts" action by removing the "*" item
     *
     * @return void
     */
    protected function initializeCreateReceiptsAction() {
        // Remove "*" template element
        $newReceipts = $this->request->getArgument('newReceipts');
        unset($newReceipts['*']);
        $this->request->setArgument('newReceipts', $newReceipts);

        // Set property mapping date format
        $propertyMappingConfiguration = $this->arguments['newReceipts']->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->forProperty('*.date')->setTypeConverterOption(\TYPO3\Flow\Property\TypeConverter\DateTimeConverter::class, \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
    }

	/**
     * Creates posted receipts
     *
     * @param \Doctrine\Common\Collections\Collection<\ThinkopenAt\Gnucash\Domain\Dto\Receipt> $newReceipts
	 * @return void
	 */
	public function createReceiptsAction(\Doctrine\Common\Collections\Collection $newReceipts) {
var_dump($newReceipts);
exit();
    }

	/**
	 * @return void
	 */
	public function newVendorAction() {
        $expenseAccounts = $this->accountRepository->findByAccountType('EXPENSE');
        $vendors = $this->vendorRepository->findAll();
        $this->view->assign('expenseAccounts', $expenseAccounts);
        $this->view->assign('vendors', $vendors);
	}

}

