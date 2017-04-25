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
	}

	/**
	 * @return void
	 */
	public function newVendorAction() {
        $expenseAccounts = $this->accountRepository->findByAccountType('EXPENSE');
        $this->view->assign('expenseAccounts', $expenseAccounts);
	}

}

