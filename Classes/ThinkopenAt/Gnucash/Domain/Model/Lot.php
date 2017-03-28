<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents the lot of an invoice
 *
 * @Flow\Entity
 */
class Lot extends AbstractGnucashModel {

	/**
	 * Account for this lot
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\Column(name="account_guid")
     * @ORM\ManyToOne
	 */	 
	protected $account = NULL;
    
	/**
	 * Whether this lot is closed
	 *
	 * @var integer
	 * @ORM\Column(name="is_closed")
	 */	 
	protected $isClosed = 0;


    /**
     * Returns the account for this lot
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Account The account for this lot
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Sets the account for this lot
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account: The lot account
     * @return void
     */
    public function setAccount(\ThinkopenAt\Gnucash\Domain\Model\Account $account) {
        $this->account = $account;
    }

    /**
     * Returns whether this lot is closed or not
     * 
	 * @return integer The closed status of this lot
     */
    public function getIsClosed() {
        return $this->isClosed;
    }

    /**
     * Sets whether this lot is closed or not
     * 
	 * @param integer $isClosed: The closed status of this lot
     * @return void
     */
    public function setIsClosed($isClosed) {
        $this->isClosed = $isClosed;
    }

}

