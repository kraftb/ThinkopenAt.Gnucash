<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents a GnuCash book file.
 * It has to implement the "GnucashBookInterface" (not available yet)
 *
 * @Flow\Entity
 */
abstract class Book {

	/**
	 * The root level account for this book
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\OneToOne
	 */	 
	protected $rootAccount = NULL;

	/**
	 * The root template account for this book
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\OneToOne
	 */	 
	protected $rootTemplate = NULL;


    /**
     * Returns the root account of this book
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Account The root account of this book
     */
    public function getRootAccount() {
        return $this->rootAccount;
    }

    /**
     * Sets the root account of this book
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $rootAccount: The root account of this book
     * @return void
     */
    public function setRootAccount(\ThinkopenAt\Gnucash\Domain\Model\Account $rootAccount) {
        $this->rootAccount = $rootAccount;
    }

}

