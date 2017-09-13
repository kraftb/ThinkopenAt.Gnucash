<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an GnuCash account.
 *
 * @Flow\Entity
 */
class AccountTag extends AbstractGnucashModel {

	/**
	 * The parent account for this account
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\ManyToOne(inversedBy="tags")
	 * @Flow\Lazy
	 */	 
	protected $account = NULL;

	/**
	 * The tag
	 *
	 * @var string
	 */	 
	protected $tag = '';


    /**
     * Returns the account of this tag
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Account The account for this tag
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Sets the account of this tag
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account: The account for this tag
     * @return void
     */
    public function setAccount(\ThinkopenAt\Gnucash\Domain\Model\Account $account) {
        $this->account = $account;
    }

    /**
     * Returns the tag value of this tag
     * 
	 * @return string The tag value of this tag
     */
    public function getTag() {
        return $this->tag;
    }

    /**
     * Sets the tag value of this tag
     * 
	 * @param string $tag: The tag value of this tag
     * @return void
     */
    public function setTag($tag) {
        $this->tag = $tag;
    }

}

