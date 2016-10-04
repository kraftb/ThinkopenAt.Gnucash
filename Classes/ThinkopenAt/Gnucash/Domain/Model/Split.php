<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents a split of a GnuCash transaction.
 *
 * @Flow\Entity
 */
class Split {

	/**
	 * The transaction associated with this split
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Transaction
	 * @ORM\ManyToOne
	 * @Flow\Lazy
	 */	 
	protected $transaction = NULL;

	/**
	 * The account associated with this split
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\ManyToOne
	 * @Flow\Lazy
	 */	 
	protected $account = NULL;

	/**
	 * A memo for this split
	 *
	 * @var string
	 */	 
	protected $memo = '';

	/**
	 * Action defined for this split
	 *
	 * @var string
	 */	 
	protected $action = ''; 

	/**
	 * The reconciled state of this split
	 *
	 * @ORM\Column(name="reconcile_state")
	 * @var string
	 */	 
	protected $reconcileState = '';

	/**
	 * The reconciled date of this split
	 *
	 * @ORM\Column(name="reconcile_date")
	 * @var DateTime
	 */	 
	protected $reconcileDate = NULL;

	/**
	 * The value of this split
	 *
	 * @var ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */	 
	protected $value = NULL; 

	/**
	 * The value numerator of this split
	 *
	 * @var integer
	 */	 
	protected $value_num = 0;

	/**
	 * The value denominator of this split
	 *
	 * @var integer
	 */	 
	protected $value_denom = 0;

	/**
	 * The quantity of this split.
     *
	 * If a transaction has splits for accounts with different currencies then the "value"
	 * field of a split will always denote values given in the currency of the transaction.
	 *
	 * While the "quantity" field will denote a value associated with the currency of the
	 * account given for this split.
	 *
	 * So the "value" properties of the splits of a transaction must sum up to "0".
	 * While this must not be true for the quantity values.
	 *
	 * @var ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */	 
	protected $quantity = NULL;

	/**
	 * The quantity numerator of this split
	 *
	 * @var integer
	 */	 
	protected $quantity_num = 0;

	/**
	 * The quantity denominator of this split
	 *
	 * @var integer
	 */	 
	protected $quantity_denom = 0;

    /**
     * Injects the value and quantity fraction instances
     *
	 * @ORM\PostLoad
     * @return void
     */
    public function injectFractions() {
        $this->value = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->value_num, $this->value_denom);
        $this->quantity = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->quantity_num, $this->quantity_denom);
    }

    // TODO: Add "lot" property

    /**
     * Returns the transaction associated with this split
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Transaction The transaction associated with this split
     */
    public function getTransaction() {
        return $this->transaction;
    }

    /**
     * Sets the transaction associated with this split
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Transaction $transaction: The transaction to associate with this split
     * @return void
     */
    public function setTransaction(\ThinkopenAt\Gnucash\Domain\Model\Transaction $transaction) {
        $this->transaction = $transaction;
    }
    
    /**
     * Returns the account associated with this split
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Accoun The account associated with this split
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Sets the account associated with this split
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account: The account to associate with this split
     * @return void
     */
    public function setAccount(\ThinkopenAt\Gnucash\Domain\Model\Account $account) {
        $this->account = $account;
    }

    /**
     * Returns the memo for this split
     * 
	 * @return string The memo for this split
     */
    public function getMemo() {
        return $this->memo;
    }

    /**
     * Sets the memo for this account
     * 
	 * @param string $memo: The memo for this split
     * @return void
     */
    public function setMemo($memo) {
        $this->memo = $memo;
    }

    /**
     * Returns the action for this split
     * 
	 * @return string The action for this split
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Sets the action for this split
     * 
	 * @param string $action: The action for this split
     * @return void
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * Returns the reconcile state for this split
     * 
	 * @return string The reconcile state for this split
     */
    public function getReconcileState() {
        return $this->reconcileState;
    }

    /**
     * Sets the reconcile state for this split
     * 
	 * @param string $reconcileState: The reconcile state for this split
     * @return void
     */
    public function setReconcileState($reconcileState) {
        $this->reconcileState = $reconcileState;
    }

    /**
     * Returns the reconcile date for this split
     * 
	 * @return string The reconcile date for this split
     */
    public function getReconcileDate() {
        return $this->reconcileDate;
    }

    /**
     * Sets the reconcile date for this split
     * 
	 * @param string $reconcileDate: The reconcile date for this split
     * @return void
     */
    public function setReconcileDate($reconcileDate) {
        $this->reconcileDate = $reconcileDate;
    }

    /**
     * Returns the value for this split
     * 
	 * @return ThinkopenAt\Gnucash\Domain\Type\Fraction The value for this split
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Sets the value for this split
     * 
	 * @param ThinkopenAt\Gnucash\Domain\Type\Fraction $value: The value for this split
     * @return void
     */
    public function setValue(\ThinkopenAt\Gnucash\Domain\Type\Fraction $value) {
        $this->value = $value;
    }

    /**
     * Returns the quantity for this split
     * 
	 * @return ThinkopenAt\Gnucash\Domain\Type\Fraction The quantity for this split
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Sets the quantity for this split
     * 
	 * @param ThinkopenAt\Gnucash\Domain\Type\Fraction $value: The quantity for this split
     * @return void
     */
    public function setQuantity(\ThinkopenAt\Gnucash\Domain\Type\Fraction $quantity) {
        $this->quantity = $quantity;
    }

}

