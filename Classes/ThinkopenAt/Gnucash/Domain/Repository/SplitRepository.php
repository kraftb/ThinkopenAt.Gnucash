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
class SplitRepository extends AbstractGnucashRepository {

    public function initializeObject() {
        \Doctrine\DBAL\Types\Type::addType('fraction', 'ThinkopenAt\Gnucash\Doctrine\Dbal\Types\FractionType');
		$orderings = array(
			'transaction.postDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'transaction.number' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'transaction' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
		$this->setDefaultOrderings($orderings);
    }

    /**
     * Finds all splits in the given date/time and pointing to one of the given accounts.
     * @todo: unfunctional
     *
     * @param \DateTime $begin: The begin date for the date/time range
     * @param \DateTime $end: The end date for the date/time range
     * @param \TYPO3\Flow\Persistence\QueryResultInterface|array $accounts: The accounts which any of the splits must match
     * @return \TYPO3\Flow\Persistence\QueryResultInterface The splits in the defined date range and account
     */
    public function findByPostDateRangeAndAccount(\DateTime $begin, \DateTime $end, $accounts) {
		if (!count($accounts)) {
			return NULL;
		}

		$query = $this->createQuery();
		$constraints = array();

		$orderings = array(
			'transaction.postDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'transaction.number' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'Persistence_Object_Identifier' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
        $query->setOrderings($orderings);

        $constraints[] = $query->greaterThanOrEqual('transaction.postDate', clone($begin));
        $constraints[] = $tmp = $query->lessThan('transaction.postDate', clone($end));
		if ($accounts instanceof \TYPO3\Flow\Persistence\QueryResultInterface) {
        	$constraints[] = $query->in('account', $accounts->toArray());
		} else {
        	$constraints[] = $query->in('account', $accounts);
		}

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

    /**
     * Finds all splits in one of the given accounts which are part of the given transactions.
     *
     * @param \TYPO3\Flow\Persistence\QueryResultInterface $accounts: The accounts which any of the splits must match
     * @param \TYPO3\Flow\Persistence\QueryResultInterface|array $transactions: The transactions which any of the splits must match
     * @return \TYPO3\Flow\Persistence\QueryResultInterface The splits in the accounts and transactions
     */
    public function findByAccountAndTransaction(\TYPO3\Flow\Persistence\QueryResultInterface $accounts, $transactions) {
		if (!count($accounts)) {
			return NULL;
		}
		if (!count($transactions)) {
			return NULL;
		}

		$query = $this->createQuery();
		$constraints = array();

		$orderings = array(
			'transaction.postDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'transaction.number' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
			'Persistence_Object_Identifier' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
        $query->setOrderings($orderings);

		if ($transactions instanceof \TYPO3\Flow\Persistence\QueryResultInterface) {
        	$constraints[] = $query->in('transaction', $transactions->toArray());
		} else {
        	$constraints[] = $query->in('transaction', $transactions);
		}

        $constraints[] = $query->in('account', $accounts->toArray());

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
	}

}

