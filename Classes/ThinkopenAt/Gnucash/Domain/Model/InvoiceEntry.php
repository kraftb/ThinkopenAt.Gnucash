<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an invoice entry.
 *
 * @Flow\Entity
 */
class InvoiceEntry {

	/**
	 * The date for this invoice entry
	 *
	 * @var \DateTime
	 */	
	protected $date = NULL;

	/**
	 * The date at which this invoice entry was entered/created
	 *
	 * @var \DateTime
	 */	
	protected $entered = NULL;

	/**
	 * Description for this invoice entry
	 *
	 * @var string
	 */	
	protected $description = '';

	/**
	 * The action (hours/project) for this invoice entry
	 *
	 * @var string
	 */	
	protected $action = '';

	/**
	 * Additional notes for this invoice entry
	 *
	 * @var string
	 */	
	protected $notes = '';

	/**
	 * Quantity numerator
	 *
	 * @var integer
	 */	
	protected $quantity_num = 0;

	/**
	 * Quantity denominator
	 *
	 * @var integer
	 */
	protected $quantity_denom = 0;

	/**
	 * The quantity of "action" for this invoice entry
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $quantity = NULL;

	/**
	 * The account for this invoice entry
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Account
	 */
	protected $account = NULL;

	/**
	 * Price numerator
	 *
	 * @var integer
	 */	
	protected $price_num = 0;

	/**
	 * Price denominator
	 *
	 * @var integer
	 */
	protected $price_denom = 0;

	/**
	 * The price of a single "quantity" of this invoice entry
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $price = NULL;

	/**
	 * Discount numerator
	 *
	 * @var integer
	 */	
	protected $discount_num = 0;

	/**
	 * Discount denominator
	 *
	 * @var integer
	 */
	protected $discount_denom = 0;

	/**
	 * The discount for this invoice entry
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $discount = NULL;

	/**
	 * The invoice of this invoice entry
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Invoice
	 */
	protected $invoice = NULL;

	/**
	 * Discount type (PERCENT/...)
	 *
	 * @var string
	 */
	protected $discountType = '';

	/**
	 * How to apply discount (PRETAX/...)
	 *
	 * @var string
	 */
	protected $discountOrder = '';

	/**
	 * Whether this invoice entry is taxable
	 *
	 * @var boolean
	 */	
	protected $taxable = false;

	/**
	 * Whether this invoice entry price has tax included
	 *
	 * @var boolean
	 */	
	protected $taxIncluded = false;

	/**
	 * The tax table to use for this invoice entry
	 *
     * @var \ThinkopenAt\Gnucash\Domain\Type\TaxTable
	 */
    protected $taxTable = NULL;


    /**
     * Injects the fraction instances
     *
	 * @ORM\PostLoad
     * @return void
     */
    public function injectFractions() {
        $this->quantity = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->quantity_num, $this->quantity_denom);
        $this->price = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->price_num, $this->price_denom);
        $this->discount = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($this->discount_num, $this->discount_denom);
    }


    /**
     * Returns the date for this invoice entry
     *
     * @return \DateTime The date for this invoice entry
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Sets the date for this invoice entry
     *
     * @param \DateTime $date: The date for this invoice entry
     * @return void
     */
    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    /**
     * Returns the date at which this invoice entry was entered/created
     *
     * @return \DateTime The date at which this invoice entry was entered/created
     */
    public function getEntered() {
        return $this->entered;
    }

    /**
     * Sets the date at which this invoice entry was entered/created
     *
     * @param \DateTime $entered: The date at which this invoice entry was entered/created
     * @return void
     */
    public function setEntered(\DateTime $entered) {
        $this->entered = $entered;
    }

    /**
     * Returns description for this invoice entry
     *
     * @return string Description for this invoice entry
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets description for this invoice entry
     *
     * @param string $description: Description for this invoice entry
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns the action (hours/project) for this invoice entry
     *
     * @return string The action (hours/project) for this invoice entry
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Sets the action (hours/project) for this invoice entry
     *
     * @param string $action: The action (hours/project) for this invoice entry
     * @return void
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * Returns additional notes for this invoice entry
     *
     * @return string Additional notes for this invoice entry
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Sets additional notes for this invoice entry
     *
     * @param string $notes: Additional notes for this invoice entry
     * @return void
     */
    public function setNotes($notes) {
        $this->notes = $notes;
    }

    /**
     * Returns the quantity of "action" for this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The quantity of "action" for this invoice entry
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Sets the quantity of "action" for this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $quantity: The quantity of "action" for this invoice entry
     * @return void
     */
    public function setQuantity(\ThinkopenAt\Gnucash\Domain\Type\Fraction $quantity) {
        $this->quantity = $quantity;
        $this->quantity_num = $quantity->getNumerator();
        $this->quantity_denom = $quantity->getDenominator();
    }

    /**
     * Returns the account for this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Account The account for this invoice entry
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Sets the account for this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Account $account: The account for this invoice entry
     * @return void
     */
    public function setAccount($account) {
        $this->account = $account;
    }

    /**
     * Returns the price of a single "quantity" of this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The price of a single "quantity" of this invoice entry
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Sets the price of a single "quantity" of this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $price: The price of a single "quantity" of this invoice entry
     * @return void
     */
    public function setPrice(\ThinkopenAt\Gnucash\Domain\Type\Fraction $price) {
        $this->price = $price;
        $this->price_num = $price->getNumerator();
        $this->price_denom = $price->getDenominator();
    }

    /**
     * Returns the discount for this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The discount for this invoice entry
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * Sets the discount for this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $discount: The discount for this invoice entry
     * @return void
     */
    public function setDiscount(\ThinkopenAt\Gnucash\Domain\Type\Fraction $discount) {
        $this->discount = $discount;
        $this->discount_num = $discount->getNumerator();
        $this->discount_denom = $discount->getDenominator();
    }

    /**
     * Returns the invoice of this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Invoice The invoice of this invoice entry
     */
    public function getInvoice() {
        return $this->invoice;
    }

    /**
     * Sets the invoice of this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice of this invoice entry
     * @return void
     */
    public function setInvoice(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $this->invoice = $invoice;
    }

    /**
     * Returns discount type (PERCENT/...)
     *
     * @return string Discount type (PERCENT/...)
     */
    public function getDiscountType() {
        return $this->discountType;
    }

    /**
     * Sets discount type (PERCENT/...)
     *
     * @param string $discountType: Discount type (PERCENT/...)
     * @return void
     */
    public function setDiscountType($discountType) {
        $this->discountType = $discountType;
    }

    /**
     * Returns how to apply discount (PRETAX/...)
     *
     * @return string How to apply discount (PRETAX/...)
     */
    public function getDiscountOrder() {
        return $this->discountOrder;
    }

    /**
     * Sets how to apply discount (PRETAX/...)
     *
     * @param string $discountOrder: How to apply discount (PRETAX/...)
     * @return void
     */
    public function setDiscountOrder($discountOrder) {
        $this->discountOrder = $discountOrder;
    }

    /**
     * Returns whether this invoice entry is taxable
     *
     * @return boolean Whether this invoice entry is taxable
     */
    public function getTaxable() {
        return $this->taxable;
    }

    /**
     * Sets whether this invoice entry is taxable
     *
     * @param boolean $taxable: Whether this invoice entry is taxable
     * @return void
     */
    public function setTaxable($taxable) {
        $this->taxable = $taxable;
    }

    /**
     * Returns whether this invoice entry price has tax included
     *
     * @return boolean Whether this invoice entry price has tax included
     */
    public function getTaxIncluded() {
        return $this->taxIncluded;
    }

    /**
     * Sets whether this invoice entry price has tax included
     *
     * @param boolean $taxIncluded: Whether this invoice entry price has tax included
     * @return void
     */
    public function setTaxIncluded($taxIncluded) {
        $this->taxIncluded = $taxIncluded;
    }

    /**
     * Returns the tax table to use for this invoice entry
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\TaxTable The tax table to use for this invoice entry
     */
    public function getTaxTable() {
        return $this->taxTable;
    }

    /**
     * Sets the tax table to use for this invoice entry
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable: The tax table to use for this invoice entry
     * @return void
     */
    public function setTaxTable(\ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable) {
        $this->taxTable = $taxTable;
    }

    public function __toString() {
        return $this->Persistence_Object_Identifier;
    }

}

