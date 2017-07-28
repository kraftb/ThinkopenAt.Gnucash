<?php
namespace ThinkopenAt\Gnucash\Domain\Dto;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an GnuCash account.
 *
 * @
 * --Flow--\--Entity
 */
class Receipt {

	/**
	 * A running index
	 *
	 * @var integer
	 */	 
	protected $index = 0;

	/**
	 * The date when the receipt was issued
	 *
	 * @var \DateTime
	 */	 
	protected $date = NULL;

	/**
	 * The vendor (Geschäft) for this receipt
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Vendor
	 * @ORM\ManyToOne
     * @Flow\Lazy
	 */	 
	protected $vendor = NULL;

	/**
	 * The amount on this receipt
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
	 */	 
	protected $amount = NULL; 

	/**
	 * The payment type (card|bar)
	 *
	 * @var string
	 */	 
	protected $paymentType = '';


    /**
     * Returns the running index
     *
     * @return integer The running index
     */
    public function getIndex() {
        return $this->index;
    }

    /**
     * Sets the running index
     *
     * @param integer $index: The running index
     * @return void
     */
    public function setIndex($index) {
        $this->index = $index;
    }

    /**
     * Returns the date when the receipt was issued
     *
     * @return \DateTime The date when the receipt was issued
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Sets the date when the receipt was issued
     *
     * @param \DateTime $date: The date when the receipt was issued
     * @return void
     */
    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    /**
     * Returns the vendor (Geschäft) for this receipt
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Vendor The vendor (Geschäft) for this receipt
     */
    public function getVendor() {
        return $this->vendor;
    }

    /**
     * Sets the vendor (Geschäft) for this receipt
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Vendor $vendor: The vendor (Geschäft) for this receipt
     * @return void
     */
    public function setVendor(\ThinkopenAt\Gnucash\Domain\Model\Vendor $vendor) {
        $this->vendor = $vendor;
    }

    /**
     * Returns the amount on this receipt
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The amount on this receipt
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Sets the amount on this receipt
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $amount: The amount on this receipt
     * @return void
     */
    public function setAmount(\ThinkopenAt\Gnucash\Domain\Type\Fraction $amount) {
        $this->amount = $amount;
    }

    /**
     * Returns the payment type (card|bar)
     *
     * @return string The payment type (card|bar)
     */
    public function getPaymentType() {
        return $this->paymentType;
    }

    /**
     * Sets the payment type (card|bar)
     *
     * @param string $paymentType: The payment type (card|bar)
     * @return void
     */
    public function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }

}


