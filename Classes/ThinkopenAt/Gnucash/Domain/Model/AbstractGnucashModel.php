<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * This domain model represents an abstract base class for any
 * GnuCash domain object. Derive from this class so any common
 * aspects like getting/setting the persistence object identifier
 * get inherited.
 *
 */
abstract class AbstractGnucashModel {


    /**
     * The object should printed its UID when converted to string
     *
     * @param return string The object identifier
     */
    public function __toString() {
        return $this->Persistence_Object_Identifier;
    }

    /**
     * Sets the Persistent_Object_Identifier
     *
     * @param string $persistentObjectIdentifier: The persistent object identifier
     */
    public function setPersistenceObjectIdentifier($persistentObjectIdentifier) {
        $this->Persistence_Object_Identifier = $persistentObjectIdentifier;
    }

    /**
     * Returns the Persistent_Object_Identifier
     *
     * @return string The persistent object identifier
     */
    public function getPersistenceObjectIdentifier() {
        return $this->Persistence_Object_Identifier;
    }

}

