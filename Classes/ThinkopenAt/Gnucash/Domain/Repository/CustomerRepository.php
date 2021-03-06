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
class CustomerRepository extends Repository {

    /**
     * Poor mans constructor
     *
     * @return void
     */
    public function initializeObject() {
        $this->setDefaultOrderings(array(
            'id' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
        ));
    }

}

