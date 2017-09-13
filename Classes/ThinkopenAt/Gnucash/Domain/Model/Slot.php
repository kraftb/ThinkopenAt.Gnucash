<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents a GnuCash slot.
 *
 * Slots are used to assign additional attributes to mostly
 * any type of GnuCash entity. So it can get used to tag or
 * mark any invoice, transaction, split etc. by some custom
 * data.
 *
 * When this slot class is used directly the relations are not
 * typed. Thus the "object" is simply a persistence object
 * identifier. There are custom TransactionSlot, SplitSlot and
 * other "TypeSlot" domain model classes which are typed and
 * allow direct access to the "object" being referenced.
 *
 * @Flow\Entity
 */
class Slot extends AbstractGnucashModel {

	/**
	 * The referenced object.
	 *
	 * @var string
	 */	 
	protected $object = '';

	/**
	 * The slot name (attribute key)
	 *
	 * @var string
	 */	 
	protected $name = '';

	/**
	 * The type of this slot
	 * 1 ... int64
	 * 3 ... numeric
	 * 4 ... string
	 * 5 ... reference
	 * 6 ... date
	 * 9 ... reference
	 * 10 ... gdate(?)
	 *
	 * @var string
	 */	 
	protected $slotType = '';

}

