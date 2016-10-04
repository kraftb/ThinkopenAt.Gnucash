<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * This domain model represents an GnuCash invoice.
 *
 * @Flow\Entity
 */
class Invoice {

	/**
	 * The identifier for this invoice (invoice:guid)
	 *
	 * @var string
	 */	 
	protected $identifier = '';

	/**
	 * The invoice owner. Can either be a customer or a vendor.
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\OwnerInterface
	 */	 
	protected $owner = NULL; 

	/**
	 * The date the invoice was opened
	 *
	 * @var \DateTime
	 */	 
	protected $opened = NULL; 

	/**
	 * The date the invoice was posted (invoice date)
	 *
	 * @var \DateTime
	 */	 
	protected $posted = NULL; 

	/**
	 * Whether this invoice is active
	 *
	 * @var boolean
	 */	 
	protected $active = TRUE; 

	/**
	 * The currency for this invoice
	 *
	 * @var string
	 */	 
	protected $currency = ''; 

	/**
	 * The entries for this invoice.
	 *
	 * @var \SplObjectStorage<\ThinkopenAt\Gnucash\Domain\Model\Entry>
	 */	 
	protected $entries = NULL;

}

