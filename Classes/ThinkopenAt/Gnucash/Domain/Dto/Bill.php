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
 * @Flow\Entity
 */
class Bill extends \ThinkopenAt\Gnucash\Domain\Model\AbstractGnucashModel {

	/**
	 * The invoice data set
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Invoice
	 * @ORM\OneToOne
     * @Flow\Lazy
	 */	 
	protected $invoice = NULL;

	/**
	 * The service period begin date (Leistungszeitraum "von")
	 *
	 * @var \DateTime
	 */	 
	protected $serviceBegin = NULL;

	/**
	 * The service period end date (Leistungszeitraum "bis")
	 *
	 * @var \DateTime
	 */	 
	protected $serviceEnd = NULL;

	/**
	 * The bill entries
	 *
	 * @var \Doctrine\Common\Collections\Collection<\ThinkopenAt\Gnucash\Domain\Dto\BillEntry>
	 */	 
	protected $entries = NULL;


    /**
     * Returns the invoice for this bill
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Model\Invoice The invoice object for this bill
     */
    public function getInvoice() {
        return $this->invoice;
    }

    /**
     * Sets the invoice for this bill
     * 
	 * @param \ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice: The invoice for this bill
     * @return void
     */
    public function setInvoice(\ThinkopenAt\Gnucash\Domain\Model\Invoice $invoice) {
        $this->invoice = $invoice;
    }

    /**
     * Returns the service begin for this bill
     * 
	 * @return \DateTime The service begin date for this bill
     */
    public function getServiceBegin() {
        return $this->serviceBegin;
    }

    /**
     * Sets the service begin for this bill
     * 
	 * @param \DateTime $serviceBegin: The service begin for this bill
     * @return void
     */
    public function setServiceBegin(\DateTime $serviceBegin) {
        $this->serviceBegin = $serviceBegin;
    }

    /**
     * Returns the service end for this bill
     * 
	 * @return \DateTime The service end date for this bill
     */
    public function getServiceEnd() {
        return $this->serviceEnd;
    }

    /**
     * Sets the service end for this bill
     * 
	 * @param \DateTime $serviceEnd: The service end for this bill
     * @return void
     */
    public function setServiceEnd(\DateTime $serviceEnd) {
        $this->serviceEnd = $serviceEnd;
    }

    /**
     * Returns the entries for this bill
     * 
	 * @return \Doctrine\Common\Collections\Collection The entries for this bill
     */
    public function getEntries() {
        return $this->entries;
    }

    /**
     * Sets the entries for this bill
     * 
	 * @param \Doctrine\Common\Collections\Collection $entries: The entries for this bill
     * @return void
     */
    public function setEntries(\Doctrine\Common\Collections\Collection $entries) {
        $this->entries = $entries;
    }

}

