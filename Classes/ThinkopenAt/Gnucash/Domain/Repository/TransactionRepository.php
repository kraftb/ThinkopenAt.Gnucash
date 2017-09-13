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
class TransactionRepository extends AbstractGnucashRepository {

    /**
     * Finds all transactions having any of the given splits
     *
     * @param \TYPO3\Flow\Persistence\QueryResultInterface $splits: The splits which any of the transactions must contain
     * @return \TYPO3\Flow\Persistence\QueryResultInterface The matching transactions
     */
    public function findBySplits(\TYPO3\Flow\Persistence\QueryResultInterface $splits) {
		$query = $this->createQuery();
		$constraints = array();

        $constraints[] = $query->in('splits.Persistence_Object_Identifier', $splits->toArray());

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}

