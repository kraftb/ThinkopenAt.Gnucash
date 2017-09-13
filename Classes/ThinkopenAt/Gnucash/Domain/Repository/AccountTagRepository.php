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
class AccountTagRepository extends Repository {

    /**
     * Finds all tags which match the specified "tag like" expression
     *
     * @param string $tag: The tag key which has to get matched using a "like" operator
     * @param \TYPO3\Flow\Persistence\QueryResultInterface Matching tags
     */
    public function findByTagLike($tag) {
        $query = $this->createQuery();
		$constraints = array();

		$constraints[] = $query->like('tag', $tag);

		$query->matching($query->logicalAnd($constraints));
		return $query->execute();
    }

}

