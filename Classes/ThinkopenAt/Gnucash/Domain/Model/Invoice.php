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
class Invoice {

	/**
	 * Invoice id (Rechnungsnummer)
	 *
	 * @var string
	 */	
	protected $id = '';

	/**
	 * The date at which this invoice has been created
	 *
	 * @var \DateTime
	 */	
	protected $opened = NULL;

	/**
	 * The date at which this invoice has been posted to the chart of accounts
	 *
	 * @var \DateTime
	 */	
	protected $posted = NULL;

	/**
	 * Any notes for this invoice
	 *
	 * @var string
	 */	
	protected $notes = '';

	/**
	 * Whether this invoice is active
	 *
	 * @var boolean
	 */	
	protected $active = false;

	/**
	 * The currency of this invoice
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Currency
	 */	
	protected $currency = NULL;

	/**
	 * The owner type for this invoice
	 *
	 * @var integer
	 */	
	protected $ownerType = 0;

	/**
	 * The owner of this invoice
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Owner
	 */	
	protected $owner = NULL;

	/**
	 * Bill terms for this invoice
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Billterm
	 */	
	protected $terms = NULL;

	/**
	 * Billing ID for this invoice
	 *
	 * @var string
	 */	
	protected $billingId = '';

	/**
	 * Transaction for this invoice
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Transaction
	 * @ORM\Column(name="post_txn")
	 */	
	protected $transaction = NULL;

	/**
	 * Lot for this invoice
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Lot
	 * @ORM\Column(name="post_lot")
	 */	
	protected $lot = NULL;

	/**
	 * Account to which this invoice gets posted
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 * @ORM\Column(name="post_acc")
	 */	
	protected $account = NULL;

	/**
	 * The bill-to type
	 *
	 * @var integer
	 */	
	protected $billtoType = 0;

	/**
	 * Bill-To (??)
	 *
	 * @var string
	 */	
	protected $billto = NULL;

	/**
	 * Charge amount numerator
	 *
	 * @var integer
	 */	
	protected $charge_amount_num = 0;

	/**
	 * Charge amount denominator
	 *
	 * @var integer
	 */
	protected $charge_amount_denom = 0;

	/**
	 * The charge amount for this invoice
	 *
	 * @var ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $chargeAmount = NULL;


    /**
     * Injects the chargeAmount fraction instance
     *
	 * @ORM\PostLoad
     * @return void
     */
    public function injectFractions() {
        $this->chargeAmount = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->charge_amount_num, $this->charge_amount_denom);
    }


    /**
     * Returns the invoice id (Rechnungsnummer)
     *
	 * @return string The invoice id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the invoice id
     *
	 * @param string $id: The invoice id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns the date when this invoice was opened (created)
     *
	 * @return \DateTime The creation date of this invoice
     */
    public function getOpened() {
        return $this->opened;
    }

    /**
     * Sets the date when this invoice was opened (created)
     *
	 * @param \DateTime $opened: The opening/creation date for this invoice
     * @return void
     */
    public function setOpened(\DateTime $opened) {
        $this->opened = $opened;
    }

    /**
     * Returns the date when this invoice was posted to the chart of accounts
     *
	 * @return \DateTime The post date of this invoice
     */
    public function getPosted() {
        return $this->posted;
    }

    /**
     * Sets the date when this invoice was poasted
     *
	 * @param \DateTime $posted: The post date for this invoice
     * @return void
     */
    public function setPosted(\DateTime $posted) {
        $this->posted = $posted;
    }

    /**
     * Returns notes for this invoice
     *
	 * @return string Notes for this invoice
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Sets notes for this invoice
     *
	 * @param string $notes: Notes for this invoice
     * @return void
     */
    public function setNotes($notes) {
        $this->notes = $notes;
    }

    /**
     * Returns whether this invoice is active or not
     *
	 * @return boolean Active state of this invoice
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Sets whether this invoice is active or not
     *
	 * @param boolean $active: Whether this invoice is active or not
     * @return void
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * Returns the currency for this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Currency The currency of this invoice
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Sets the currency for this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Currency $currency: The invoice currency
     * @return void
     */
    public function setCurrency(\ThinkopenAt\Gnucash\Domain\Model\Currency $currency) {
        $this->currency = $currency;
    }

    /**
     * Returns the owner type for this invoice (2=customer, 1=vendor)
     *
	 * @return integer The owner type for this invoice
     */
    public function getOwnerType() {
        return $this->ownerType;
    }

    /**
     * Sets the owner type for this invoice
     *
	 * @param integer $ownerType: The owner type for this invoice
     * @return void
     */
    public function setOwnerType($ownerType) {
        $this->ownerType = $ownerType;
    }

    /**
     * Returns the owner (vendor/customer) for this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Owner The vendor/customer of this invoice
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Sets the owner (vendor/customer) for this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Owner $owner: The vendor/customer of this invoice
     * @return void
     */
    public function setOwner(\ThinkopenAt\Gnucash\Domain\Model\Owner $owner) {
        $this->owner = $owner;
    }

    /**
     * Returns the bill terms for this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Billterm The bill terms for this invoice
     */
    public function getTerms() {
        return $this->terms;
    }

    /**
     * Sets the bill terms for this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Billterm $terms: The bill terms for this invoice
     * @return void
     */
    public function setTerms(\ThinkopenAt\Gnucash\Domain\Model\Billterm $terms) {
        $this->terms = $terms;
    }

    /**
     * Returns the invoice billing id
     *
	 * @return string The invoice billing id
     */
    public function getBillingId() {
        return $this->billingId;
    }

    /**
     * Sets the invoice billing id
     *
	 * @param string $billingId: The invoice billing id
     * @return void
     */
    public function setBillingId($billingId) {
        $this->billingId = $billingId;
    }

    /**
     * Returns the transaction representing this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Transaction The transaction for this invoice
     */
    public function getTransaction() {
        return $this->transaction;
    }

    /**
     * Sets the transaction for this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Transaction $transaction: The transaction for this invoice
     * @return void
     */
    public function setTransaction(\ThinkopenAt\Gnucash\Domain\Model\Transaction $transaction) {
        $this->transaction = $transaction;
    }

    /**
     * Returns the lot for this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Lot The lot for this invoice
     */
    public function getLot() {
        return $this->lot;
    }

    /**
     * Sets the lot for this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Lot $lot: The lot for this invoice
     * @return void
     */
    public function setLot(\ThinkopenAt\Gnucash\Domain\Model\Lot $lot) {
        $this->lot = $lot;
    }

    /**
     * Returns the account onto which to post this invoice
     *
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Account The account onto which to post this invoice
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Sets the account onto which to post this invoice
     *
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account: The account onto which to post this invoice
     * @return void
     */
    public function setAccount(\ThinkopenAt\Gnucash\Domain\Model\Account $account) {
        $this->account = $account;
    }

    /**
     * Returns the bill-to type for this invoice
     *
	 * @return integer The "bill-to" type for this invoice
     */
    public function getBilltoType() {
        return $this->billtoType;
    }

    /**
     * Sets the bill-to type for this invoice
     *
	 * @param integer $billtoType: The "bill-to" type for this invoice
     * @return void
     */
    public function setBilltoType($billtoType) {
        $this->billtoType = $billtoType;
    }

    /**
     * Returns the bill-to for this invoice
     *
	 * @return string The "bill-to" for this invoice
     */
    public function getBillto() {
        return $this->billto;
    }

    /**
     * Sets the bill-to for this invoice
     *
	 * @param string $billto: The "bill-to" for this invoice
     * @return void
     */
    public function setBillto($billto) {
        $this->billto = $billto;
    }

    /**
     * Returns the charge amount for this invoice
     *
	 * @return ThinkopenAt\Gnucash\Domain\Type\Fraction The charge amount for this invoice
     */
    public function getChargeAmount() {
        return $this->chargeAmount;
    }

    /**
     * Sets the charge amount for this invoice
     *
	 * @param ThinkopenAt\Gnucash\Domain\Type\Fraction $chargeAmount: The charge amount for this invoice
     * @return void
     */
    public function setChargeAmount(\ThinkopenAt\Gnucash\Domain\Type\Fraction $chargeAmount) {
        $this->chargeAmount = $chargeAmount;
        $this->charge_amount_num = $chargeAmount->getNumerator();
        $this->charge_amount_denom = $chargeAmount->getDenominator();
    }

    public function __toString() {
        return $this->Persistence_Object_Identifier;
    }

}

