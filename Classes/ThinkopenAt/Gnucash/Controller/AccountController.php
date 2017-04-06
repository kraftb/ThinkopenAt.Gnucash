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

class AccountController extends ActionController {

	/**
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account
	 * @return void
	 */
	public function indexAction(Account $account = NULL) {
        $this->view->assign('account', $account);
        $this->view->assign('subAccounts', $this->accountRepository->findByParent($account));
//		if ($account) {
//			$this->view->assign('transactions', $this->transactionRepository->findByAccount($account));
//		}
	}

}

