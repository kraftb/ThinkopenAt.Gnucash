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
class Customer extends AbstractVendorCustomer {

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

}

