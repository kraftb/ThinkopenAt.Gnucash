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
class SplitRepository extends Repository {

    public function initializeObject() {
        \Doctrine\DBAL\Types\Type::addType('fraction', 'ThinkopenAt\Gnucash\Doctrine\Dbal\Types\FractionType');
    }

    /**
     * Finds all splits in the given date/time and pointing to one of the given accounts.
     * @todo: unfunctional
     *
     * @param \DateTime $begin: The begin date for the date/time range
     * @param \DateTime $end: The end date for the date/time range
     * @param \TYPO3\Flow\Persistence\QueryResultInterface The accounts which any of the splits must match
     */
    public function findByPostDateRangeAndAccount(\DateTime $begin, \DateTime $end, \TYPO3\Flow\Persistence\QueryResultInterface $accounts) {
		$query = $this->createQuery();
		$constraints = array();

		$orderings = array(
			'transaction.postDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'transaction.number' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
        $query->setOrderings($orderings);

        $constraints[] = $query->greaterThanOrEqual('transaction.postDate', $begin);
        $constraints[] = $query->lessThan('transaction.postDate', $end);
        $constraints[] = $query->in('account', $accounts->toArray());

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}

