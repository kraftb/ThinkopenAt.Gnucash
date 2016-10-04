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
class AccountRepository extends Repository {

    /**
     * Finds all accounts whose parent has assigned a specific code
     *
     * @param string $code: The code which has to get matched
     * @param \TYPO3\Flow\Persistence\QueryResultInterface Matching accounts
     */
    public function findChildrenByCode($code) {
        $query = $this->createQuery();
		$constraints = array();

		$orderings = array(
			'name' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
		$query->setOrderings($orderings);

		$constraints[] = $query->equals('parent.code', $code);

		$query->matching($query->logicalAnd($constraints));
		return $query->execute();
    }

}
