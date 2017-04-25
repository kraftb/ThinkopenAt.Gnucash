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
class Employee extends AbstractPerson {

	/**
	 * The language for this employee
	 *
	 * @var string
	 */	 
	protected $language = '';

	/**
	 * The ACL for this employee
	 *
	 * @var string
	 */	 
	protected $acl = '';

	/**
	 * Credit card information of this customer
     * @todo: Create domain model for credit card
	 *
	 * @var string
	 */	 
	protected $creditCard = '';

	/**
	 * Work day numerator
	 *
	 * @var integer
	 */	
	protected $workday_num = 0;

	/**
	 * Work day denominator
	 *
	 * @var integer
	 */
	protected $workday_denom = 0;

	/**
	 * Work days for this employee
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $workday = NULL;

	/**
	 * Rate/wage numerator
	 *
	 * @var integer
	 */	
	protected $rate_num = 0;

	/**
	 * Rate/wage denominator
	 *
	 * @var integer
	 */
	protected $rate_denom = 0;

	/**
	 * Rate/wage of this employee
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $rate = NULL;


    /**
     * Returns the language used for this employee
     *
     * @return string The language of this employee
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Sets the languge for this employee
     *
     * @param string $language: The language for this employee
     * @return void
     */
    public function setLanguage($language) {
        $this->language = $language;
    }

    /**
     * Returns the ACL for this employee
     *
     * @return string The ACL for this employee
     */
    public function getAcl() {
        return $this->acl;
    }

    /**
     * Sets the ACL for this employee
     *
     * @param string $acl: The ACL for this employee
     * @return void
     */
    public function setAcl($acl) {
        $this->acl = $acl;
    }

    /**
     * Returns the credit card GUID for this employee
     *
     * @return string The credit card GUID for this employee
     */
    public function getCreditCard() {
        return $this->creditCard;
    }

    /**
     * Sets the credit card GUID for this employee
     *
     * @param string $creditCard: The credit card GUID for this employee
     * @return void
     */
    public function setCreditCard($creditCard) {
        $this->creditCard = $creditCard;
    }

    /**
     * STOPPED
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
     * @return \ThinkopenAt\Gnucash\Domain\Model\TaxTable The tax table for invoices for this customer
     */
    public function getTaxTable() {
        return $this->taxTable;
    }

    /**
     * Sets the tax table for invoices for this customer
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\TaxTable $taxTable: The tax table for invoices for this customer
     * @return void
     */
    public function setTaxTable(\ThinkopenAt\Gnucash\Domain\Model\TaxTable $taxTable) {
        $this->taxTable = $taxTable;
    }

}

