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
class AbstractGnucashRepository extends Repository {

    /**
     * Magic call method for repository methods.
     *
     * Provides three methods
     *  - findBy<PropertyName>($value, $caseSensitive = TRUE, $cacheResult = FALSE)
     *  - findOneBy<PropertyName>($value, $caseSensitive = TRUE, $cacheResult = FALSE)
     *  - countBy<PropertyName>($value, $caseSensitive = TRUE)
     *
     * @param string $method Name of the method
     * @param array $arguments The arguments
     * @return mixed The result of the repository method
     * @api
     */
    public function __call($method, $arguments) {
        if ((strlen($method) > strlen('findBy')) && strpos($method, 'findBy') === 0) {
        	$query = $this->createQuery();
	        $cacheResult = isset($arguments[2]) ? (boolean)$arguments[2] : false;

            $propertyName = lcfirst(substr($method, 6));
            if (is_array($arguments[0])) {
                return $query->matching($query->in($propertyName, $arguments[0]))->execute($cacheResult);
            } elseif ($arguments[0] instanceof \TYPO3\Flow\Persistence\Doctrine\QueryResult) {
                return $query->matching($query->in($propertyName, $arguments[0]->toArray()))->execute($cacheResult);
			}
		}

		return parent::__call($method, $arguments);
    }

}

