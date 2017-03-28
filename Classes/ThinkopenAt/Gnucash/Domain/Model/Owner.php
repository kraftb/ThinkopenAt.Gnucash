<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents a owner of an invoice (vendor or customer).
 *
 * How to handle the fact that owners can either be a Vendor or a Customer
 * domain model is not completely clear.
 *
 * @Flow\Entity
 */
class Owner {

	/**
	 * The tax table to use for this invoice entry
	 *
     * @var \ThinkopenAt\Gnucash\Domain\Type\TaxTable
	 */
    protected $taxTable = NULL;


    /**
     * Returns the tax table to use for this owner
     *
     * @return \ThinkopenAt\Gnucash\Domain\Type\TaxTable The tax table to use for this owner
     */
    public function getTaxTable() {
        return $this->taxTable;
    }

    /**
     * Sets the tax table to use for this owner
     *
     * @param \ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable: The tax table to use for this owner
     * @return void
     */
    public function setTaxTable(\ThinkopenAt\Gnucash\Domain\Type\TaxTable $taxTable) {
        $this->taxTable = $taxTable;
    }

}

