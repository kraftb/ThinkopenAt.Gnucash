<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Transaction {

	/**
	 * The identifier for this transaction
	 *
	 * @var string
	 */	 
	protected $identifier = '';

	/**
	 * The currency for this transaction
	 *
	 * @var string
	 */	 
	protected $currency = ''; 

	/**
	 * The number of this transaction
	 *
	 * @var string
	 */	 
	protected $number = '';

	/**
	 * The date this transaction was entered
	 *
	 * @var \DateTime
	 */	 
	protected $entered = NULL; 

	/**
	 * The date this transaction was posted (transaction date)
	 *
	 * @var \DateTime
	 */	 
	protected $posted = NULL; 

	/**
	 * A description for this transaction
	 *
	 * @var string
	 */	 
	protected $description = NULL; 

	/**
	 * The splits of this transaction
	 *
	 * @var \SplObjectStorage<\ThinkopenAt\Gnucash\Domain\Model\Split>
	 */	 
	protected $splits = NULL;

}

