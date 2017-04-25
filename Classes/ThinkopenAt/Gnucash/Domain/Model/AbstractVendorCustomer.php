<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents an abstract GnuCash
 * vendor domain model. In fact the properties here
 * are exactly the same as those for a vendor, but
 * the @Flow\Entity annotation can't be given to
 * this domain model as it is also used by the
 * "Customer" domain model. So there is a common
 * abstract class (this one) for both the real Vendor
 * and Customer domain model classes.
 */
abstract class AbstractVendorCustomer extends AbstractPerson {

	/**
	 * Any notes for this vendor/customer
	 *
	 * @var string
	 */	 
	protected $notes = '';

	/**
	 * Invoice terms for this customer
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Billterm
     * @ORM\ManyToOne
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
     * @var \ThinkopenAt\Gnucash\Domain\Model\TaxTable
     * @ORM\ManyToOne
	 */
    protected $taxTable = NULL;

	/**
	 * Whether to enable tax override for this customer
	 *
	 * @var boolean
	 */	
	protected $taxOverride = false;


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

}

