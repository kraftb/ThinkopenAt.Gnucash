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
class AccountRepository extends AbstractGnucashRepository {

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

    /**
     * Finds accounts which contain the given code-element
     *
     * @param string $code: The code element which has to get matched
     * @return \TYPO3\Flow\Persistence\QueryResultInterface Matching accounts
     */
    public function findWithCodeElement($code) {
        $query = $this->createQuery();
		$constraints = array();

		$orderings = array(
			'name' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		);
		$query->setOrderings($orderings);

		$constraints[] = $query->equals('code', $code);
		$constraints[] = $query->like('code', '%|' . $code);
		$constraints[] = $query->like('code', $code . '|%');
		$constraints[] = $query->like('code', '%|' . $code . '|%');

		$query->matching($query->logicalOr($constraints));
		return $query->execute();
	}

    /**
     * Finds all accounts having the given tag
     *
     * @param \TYPO3\Flow\Persistence\QueryResultInterface $tags: The tags which any of the accounts must match
     * @return \TYPO3\Flow\Persistence\QueryResultInterface The matching accounts
     */
    public function findByTags(\TYPO3\Flow\Persistence\QueryResultInterface $tags) {
		$query = $this->createQuery();
		$constraints = array();

        $constraints[] = $query->in('tags.Persistence_Object_Identifier', $tags->toArray());

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}

