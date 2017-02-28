<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an GnuCash customer.
 *
 * @Flow\Entity
 */
class Customer {

	/**
	 * The name of this customer
	 *
	 * @var string
	 */	 
	protected $name = '';

	/**
	 * The id for this customer
	 *
	 * @var string
	 */	 
	protected $id = '';

	/**
	 * Any notes for this customer
	 *
	 * @var string
	 */	 
	protected $notes = '';

	/**
	 * Whether this customer is active
	 *
	 * @var boolean
	 */	
	protected $active = false;

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
	 * Discount for this customer 
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $discount = NULL;

	/**
	 * Credit numerator
	 *
	 * @var integer
	 */	
	protected $credit_num = 0;

	/**
	 * Credit denominator
	 *
	 * @var integer
	 */
	protected $credit_denom = 0;

	/**
	 * Credit for this customer
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $credit = NULL;

	/**
	 * The currency for this customer
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Currency
	 */	
	protected $currency = NULL;

	/**
	 * Whether to enable tax override for this customer
	 *
	 * @var boolean
	 */	
	protected $taxOverride = false;

	/**
	 * Address name for this customer
	 *
	 * @var string
	 */	
	protected $addressName = '';

	/**
	 * Address line 1
	 *
	 * @var string
	 */	
	protected $addressLine1 = '';

	/**
	 * Address line 2
	 *
	 * @var string
	 */	
	protected $addressLine2 = '';

	/**
	 * Address line 3
	 *
	 * @var string
	 */	
	protected $addressLine3 = '';

	/**
	 * Address line 4
	 *
	 * @var string
	 */	
	protected $addressLine4 = '';

	/**
	 * Address phone
	 *
	 * @var string
	 */	
	protected $addressPhone = '';

	/**
	 * Address fax
	 *
	 * @var string
	 */	
	protected $addressFax = '';

	/**
	 * Address email
	 *
	 * @var string
	 */	
	protected $addressEmail = '';

	/**
	 * Shipping address name for this customer
	 *
	 * @var string
	 */	
	protected $shippingAddressName = '';

	/**
	 * Shipping address line 1
	 *
	 * @var string
	 */	
	protected $shippingAddressLine1 = '';

	/**
	 * Shipping address line 2
	 *
	 * @var string
	 */	
	protected $shippingAddressLine2 = '';

	/**
	 * Shipping address line 3
	 *
	 * @var string
	 */	
	protected $shippingAddressLine3 = '';

	/**
	 * Shipping address line 4
	 *
	 * @var string
	 */	
	protected $shippingAddressLine4 = '';

	/**
	 * Shipping address phone
	 *
	 * @var string
	 */	
	protected $shippingAddressPhone = '';

	/**
	 * Shipping address fax
	 *
	 * @var string
	 */	
	protected $shippingAddressFax = '';

	/**
	 * Shipping address email
	 *
	 * @var string
	 */	
	protected $shippingAddressEmail = '';

	/**
	 * Invoice terms for this customer
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Billterm
	 */	
	protected $terms = NULL;

	/**
	 * Whether invoice for this customer have tax included
	 *
	 * @var boolean
	 */	
	protected $taxIncluded = false;

	/**
	 * The tax table for invoices for this customer
	 *
     * @var \ThinkopenAt\Gnucash\Domain\Type\TaxTable
	 */
    protected $taxTable = NULL;


    /**
     * Returns the name of this customer
     *
     * @return string The name of this customer
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name of this customer
     *
     * @param string $name: The name of this customer
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the id for this customer
     *
     * @return string The id for this customer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the id for this customer
     *
     * @param string $id: The id for this customer
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns any notes for this customer
     *
     * @return string Any notes for this customer
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Sets any notes for this customer
     *
     * @param string $notes: Any notes for this customer
     * @return void
     */
    public function setNotes($notes) {
        $this->notes = $notes;
    }

    /**
     * Returns whether this customer is active
     *
     * @return boolean Whether this customer is active
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Sets whether this customer is active
     *
     * @param boolean $active: Whether this customer is active
     * @return void
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * Returns discount for this customer
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction Discount for this customer
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * Sets discount for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $discount: Discount for this customer
     * @return void
     */
    public function setDiscount(\ThinkopenAt\Gnucash\Domain\Type\Fraction $discount) {
        $this->discount = $discount;
        $this->discount_num = $discount->getNumerator();
        $this->discount_denom = $discount->getDenominator();
    }

    /**
     * Returns credit for this customer
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction Credit for this customer
     */
    public function getCredit() {
        return $this->credit;
    }

    /**
     * Sets credit for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $credit: Credit for this customer
     * @return void
     */
    public function setCredit(\ThinkopenAt\Gnucash\Domain\Type\Fraction $credit) {
        $this->credit = $credit;
        $this->credit_num = $credit->getNumerator();
        $this->credit_denom = $credit->getDenominator();
    }

    /**
     * Returns the currency for this customer
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Currency The currency for this customer
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Sets the currency for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Currency $currency: The currency for this customer
     * @return void
     */
    public function setCurrency(\ThinkopenAt\Gnucash\Domain\Model\Currency $currency) {
        $this->currency = $currency;
    }

    /**
     * Returns whether to enable tax override for this customer
     *
     * @return boolean Whether to enable tax override for this customer
     */
    public function getTaxOverride() {
        return $this->taxOverride;
    }

    /**
     * Sets whether to enable tax override for this customer
     *
     * @param boolean $taxOverride: Whether to enable tax override for this customer
     * @return void
     */
    public function setTaxOverride($taxOverride) {
        $this->taxOverride = $taxOverride;
    }

    /**
     * Returns address name for this customer
     *
     * @return string Address name for this customer
     */
    public function getAddressName() {
        return $this->addressName;
    }

    /**
     * Sets address name for this customer
     *
     * @param string $addressName: Address name for this customer
     * @return void
     */
    public function setAddressName($addressName) {
        $this->addressName = $addressName;
    }

    /**
     * Returns address line 1
     *
     * @return string Address line 1
     */
    public function getAddressLine1() {
        return $this->addressLine1;
    }

    /**
     * Sets address line 1
     *
     * @param string $addressLine1: Address line 1
     * @return void
     */
    public function setAddressLine1($addressLine1) {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * Returns address line 2
     *
     * @return string Address line 2
     */
    public function getAddressLine2() {
        return $this->addressLine2;
    }

    /**
     * Sets address line 2
     *
     * @param string $addressLine2: Address line 2
     * @return void
     */
    public function setAddressLine2($addressLine2) {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * Returns address line 3
     *
     * @return string Address line 3
     */
    public function getAddressLine3() {
        return $this->addressLine3;
    }

    /**
     * Sets address line 3
     *
     * @param string $addressLine3: Address line 3
     * @return void
     */
    public function setAddressLine3($addressLine3) {
        $this->addressLine3 = $addressLine3;
    }

    /**
     * Returns address line 4
     *
     * @return string Address line 4
     */
    public function getAddressLine4() {
        return $this->addressLine4;
    }

    /**
     * Sets address line 4
     *
     * @param string $addressLine4: Address line 4
     * @return void
     */
    public function setAddressLine4($addressLine4) {
        $this->addressLine4 = $addressLine4;
    }

    /**
     * Returns address phone
     *
     * @return string Address phone
     */
    public function getAddressPhone() {
        return $this->addressPhone;
    }

    /**
     * Sets address phone
     *
     * @param string $addressPhone: Address phone
     * @return void
     */
    public function setAddressPhone($addressPhone) {
        $this->addressPhone = $addressPhone;
    }

    /**
     * Returns address fax
     *
     * @return string Address fax
     */
    public function getAddressFax() {
        return $this->addressFax;
    }

    /**
     * Sets address fax
     *
     * @param string $addressFax: Address fax
     * @return void
     */
    public function setAddressFax($addressFax) {
        $this->addressFax = $addressFax;
    }

    /**
     * Returns address email
     *
     * @return string Address email
     */
    public function getAddressEmail() {
        return $this->addressEmail;
    }

    /**
     * Sets address email
     *
     * @param string $addressEmail: Address email
     * @return void
     */
    public function setAddressEmail($addressEmail) {
        $this->addressEmail = $addressEmail;
    }

    /**
     * Returns shipping address name for this customer
     *
     * @return string Shipping address name for this customer
     */
    public function getShippingAddressName() {
        return $this->shippingAddressName;
    }

    /**
     * Sets shipping address name for this customer
     *
     * @param string $shippingAddressName: Shipping address name for this customer
     * @return void
     */
    public function setShippingAddressName($shippingAddressName) {
        $this->shippingAddressName = $shippingAddressName;
    }

    /**
     * Returns shipping address line 1
     *
     * @return string Shipping address line 1
     */
    public function getShippingAddressLine1() {
        return $this->shippingAddressLine1;
    }

    /**
     * Sets shipping address line 1
     *
     * @param string $shippingAddressLine1: Shipping address line 1
     * @return void
     */
    public function setShippingAddressLine1($shippingAddressLine1) {
        $this->shippingAddressLine1 = $shippingAddressLine1;
    }

    /**
     * Returns shipping address line 2
     *
     * @return string Shipping address line 2
     */
    public function getShippingAddressLine2() {
        return $this->shippingAddressLine2;
    }

    /**
     * Sets shipping address line 2
     *
     * @param string $shippingAddressLine2: Shipping address line 2
     * @return void
     */
    public function setShippingAddressLine2($shippingAddressLine2) {
        $this->shippingAddressLine2 = $shippingAddressLine2;
    }

    /**
     * Returns shipping address line 3
     *
     * @return string Shipping address line 3
     */
    public function getShippingAddressLine3() {
        return $this->shippingAddressLine3;
    }

    /**
     * Sets shipping address line 3
     *
     * @param string $shippingAddressLine3: Shipping address line 3
     * @return void
     */
    public function setShippingAddressLine3($shippingAddressLine3) {
        $this->shippingAddressLine3 = $shippingAddressLine3;
    }

    /**
     * Returns shipping address line 4
     *
     * @return string Shipping address line 4
     */
    public function getShippingAddressLine4() {
        return $this->shippingAddressLine4;
    }

    /**
     * Sets shipping address line 4
     *
     * @param string $shippingAddressLine4: Shipping address line 4
     * @return void
     */
    public function setShippingAddressLine4($shippingAddressLine4) {
        $this->shippingAddressLine4 = $shippingAddressLine4;
    }

    /**
     * Returns shipping address phone
     *
     * @return string Shipping address phone
     */
    public function getShippingAddressPhone() {
        return $this->shippingAddressPhone;
    }

    /**
     * Sets shipping address phone
     *
     * @param string $shippingAddressPhone: Shipping address phone
     * @return void
     */
    public function setShippingAddressPhone($shippingAddressPhone) {
        $this->shippingAddressPhone = $shippingAddressPhone;
    }

    /**
     * Returns shipping address fax
     *
     * @return string Shipping address fax
     */
    public function getShippingAddressFax() {
        return $this->shippingAddressFax;
    }

    /**
     * Sets shipping address fax
     *
     * @param string $shippingAddressFax: Shipping address fax
     * @return void
     */
    public function setShippingAddressFax($shippingAddressFax) {
        $this->shippingAddressFax = $shippingAddressFax;
    }

    /**
     * Returns shipping address email
     *
     * @return string Shipping address email
     */
    public function getShippingAddressEmail() {
        return $this->shippingAddressEmail;
    }

    /**
     * Sets shipping address email
     *
     * @param string $shippingAddressEmail: Shipping address email
     * @return void
     */
    public function setShippingAddressEmail($shippingAddressEmail) {
        $this->shippingAddressEmail = $shippingAddressEmail;
    }

    /**
     * Returns invoice terms for this customer
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Billterm Invoice terms for this customer
     */
    public function getTerms() {
        return $this->terms;
    }

    /**
     * Sets invoice terms for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Billterm $terms: Invoice terms for this customer
     * @return void
     */
    public function setTerms(\ThinkopenAt\Gnucash\Domain\Model\Billterm $terms) {
        $this->terms = $terms;
    }

    /**
     * Returns whether invoices for this customer have tax included
     *
     * @return boolean Whether invoices for this customer have tax included
     */
    public function getTaxIncluded() {
        return $this->taxIncluded;
    }

    /**
     * Sets whether invoices for this customer have tax included
     *
     * @param boolean $taxIncluded: Whether invoices for this customer have tax included
     * @return void
     */
    public function setTaxIncluded($taxIncluded) {
        $this->taxIncluded = $taxIncluded;
    }

    /**
     * Returns the tax table for invoices for this customer
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\TaxTable The tax table for invoices for this customer
     */
    public function getTaxTable() {
        return $this->taxTable;
    }

    /**
     * Sets the tax table for invoices for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable: The tax table for invoices for this customer
     * @return void
     */
    public function setTaxTable(\ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable) {
        $this->taxTable = $taxTable;
    }


    public function __toString() {
        return $this->Persistence_Object_Identifier;
    }

}


