<?php
namespace ThinkopenAt\Gnucash\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class InvoiceRepository extends Repository {


	/**
	 * Poor mans constructor
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->setDefaultOrderings([
			'id' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING,
			'opened' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING
		]);
	}

}

