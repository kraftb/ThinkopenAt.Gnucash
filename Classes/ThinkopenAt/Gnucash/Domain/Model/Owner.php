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

}

