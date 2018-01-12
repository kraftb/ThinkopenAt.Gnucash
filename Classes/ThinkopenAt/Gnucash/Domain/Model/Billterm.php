<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents bill terms of an invoice
 *
 * @Flow\Entity
 */
class Billterm {

	/**
	 * Name for this billterm
	 *
	 * @var string
	 */	
	protected $name = '';

	/**
	 * Description for this billterm
	 *
	 * @var string
	 */	
	protected $description = '';

	/**
	 * Reference/usage count for this billterm
	 *
	 * @var integer
	 */	
	protected $referenceCount = 0;

	/**
	 * Visibility status of this billterm
	 *
	 * @var boolean
	 */	
	protected $invisible = false;

	/**
	 * Parent billterm for this billterm
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Billterm
     * @ORM\ManyToOne
	 */	
	protected $parent = NULL;

	/**
	 * Type for this billterm (i.e. "GNC_TERM_TYPE_DAYS")
	 *
	 * @var string
	 */	
	protected $billtermType = '';

	/**
	 * Number of days until invoices according to
	 * this billterm are due.
	 *
	 * @var integer
	 */	
	protected $dueDays = 0;

	/**
	 * Number of days for which invoices according to
	 * this billterm are granted a discount (DE: Skonto).
	 *
	 * @var integer
	 */	
	protected $discountDays = 0;

	/**
	 * Discount amount numerator
	 *
	 * @var integer
	 */
	protected $discount_num = 0;

	/**
	 * Discount amount denominator
	 *
	 * @var integer
	 */
	protected $discount_denom = 0;

	/**
	 * Discount for invoices adhering to
	 * this billterm.
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Type\Fraction
     * @Flow\Transient
	 */
	protected $discount = NULL;

	/**
	 * Cutoff (?)
	 *
	 * @var integer
	 */
	protected $cutoff = 0;


    /**
     * Returns name for this billterm
     *
     * @return string Name for this billterm
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets name for this billterm
     *
     * @param string $name: Name for this billterm
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns description for this billterm
     *
     * @return string Description for this billterm
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets description for this billterm
     *
     * @param string $description: Description for this billterm
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns reference/usage count for this billterm
     *
     * @return integer Reference/usage count for this billterm
     */
    public function getReferenceCount() {
        return $this->referenceCount;
    }

    /**
     * Sets reference/usage count for this billterm
     *
     * @param integer $referenceCount: Reference/usage count for this billterm
     * @return void
     */
    public function setReferenceCount($referenceCount) {
        $this->referenceCount = $referenceCount;
    }

    /**
     * Returns visibility status of this billterm
     *
     * @return boolean Visibility status of this billterm
     */
    public function getInvisible() {
        return $this->invisible;
    }

    /**
     * Sets visibility status of this billterm
     *
     * @param boolean $invisible: Visibility status of this billterm
     * @return void
     */
    public function setInvisible($invisible) {
        $this->invisible = $invisible;
    }

    /**
     * Returns parent billterm for this billterm
     *
     * @return \ThinkopenAt\Gnucash\Domain\Model\Billterm Parent billterm for this billterm
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Sets parent billterm for this billterm
     *
     * @param \ThinkopenAt\Gnucash\Domain\Model\Billterm $parent: Parent billterm for this billterm
     * @return void
     */
    public function setParent(\ThinkopenAt\Gnucash\Domain\Model\Billterm $parent) {
        $this->parent = $parent;
    }

    /**
     * Returns type for this billterm (i.e. "GNC_TERM_TYPE_DAYS")
     *
     * @return string Type for this billterm (i.e. "GNC_TERM_TYPE_DAYS")
     */
    public function getBilltermType() {
        return $this->billtermType;
    }

    /**
     * Sets type for this billterm (i.e. "GNC_TERM_TYPE_DAYS")
     *
     * @param string $billtermType: Type for this billterm (i.e. "GNC_TERM_TYPE_DAYS")
     * @return void
     */
    public function setBilltermType($billtermType) {
        $this->billtermType = $billtermType;
    }

    /**
     * Returns number of days until invoices according to
     *
     * @return integer Number of days until invoices according to
     */
    public function getDueDays() {
        return $this->dueDays;
    }

    /**
     * Sets number of days until invoices according to
     *
     * @param integer $dueDays: Number of days until invoices according to
     * @return void
     */
    public function setDueDays($dueDays) {
        $this->dueDays = $dueDays;
    }

    /**
     * Returns number of days for which invoices according to
     *
     * @return integer Number of days for which invoices according to
     */
    public function getDiscountDays() {
        return $this->discountDays;
    }

    /**
     * Sets number of days for which invoices according to
     *
     * @param integer $discountDays: Number of days for which invoices according to
     * @return void
     */
    public function setDiscountDays($discountDays) {
        $this->discountDays = $discountDays;
    }

    /**
     * Returns discount for invoices adhering to this billterm
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction Discount for invoices adhering to this billterm
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * Sets discount for invoices adhering to this billterm
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $discount: Discount for invoices adhering to this billterm
     * @return void
     */
    public function setDiscount(\ThinkopenAt\Gnucash\Domain\Type\Fraction $discount) {
        $this->discount = $discount;
        $this->discount_num = $discount->getNumerator();
        $this->discount_denom = $discount->getDenominator();
    }

    /**
     * Returns cutoff (?)
     *
     * @return integer Cutoff (?)
     */
    public function getCutoff() {
        return $this->cutoff;
    }

    /**
     * Sets cutoff (?)
     *
     * @param integer $cutoff: Cutoff (?)
     * @return void
     */
    public function setCutoff($cutoff) {
        $this->cutoff = $cutoff;
    }

}

