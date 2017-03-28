<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * This domain model represents a transaction of a GnuCash transaction.
 * A transaction contains (has assigned) multiple splits. The transaction
 * entity holds the information about date/time and gnucash index number
 * of the transaction.
 *
 * @Flow\Entity
 */
class Transaction extends AbstractGnucashModel {

	/**
	 * The "main" currency used by this transaction.
     *
     * The amount transfered from/to an account by a transaction split is defined
     * by the transaction split field "quantity".
     *
     * Usually this will be the same as in the split field "value".
     *
     * But ... if a transaction (this domain model) defines a different currency here with
     * this "currency" field then assigned to one of the accounts used by the splits,
     * then those split fields will differ.
     *
     * The main goal of this "currency" field is to define a common currency for all of the
     * splits so the appropriate "values" can get calculated. The "value" fields of all
     * splits in a transaction thus have to sum up to "0".
     *
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Model\Currency
     * @ORM\ManyToOne
	 */	 
	protected $currency = '';

	/**
	 * The Gnucash index-number for this transaction
	 *
     * @var string
	 */	 
	protected $number = '';

	/**
	 * The date to which this transaction is posted
	 *
	 * @var \DateTime
	 */	 
	protected $postDate = NULL;

	/**
	 * The date at which this transaction was entered
	 *
	 * @var \DateTime
	 */	 
	protected $enterDate = NULL;

	/**
	 * A description for this transaction
	 *
     * @var string
	 */	 
	protected $description = '';

	/**
	 * The splits of this transaction
	 *
     * @var Collection<\ThinkopenAt\Gnucash\Domain\Model\Split>
     * @ORM\OneToMany(mappedBy="transaction", cascade={"persist"})
	 */	 
	protected $splits = NULL;

    /**
     * Returns the currency of this transaction
     * 
	 * @return string The currency of this transaction
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Sets the currency of this transaction
     * 
	 * @param string $currency: The currency for this transaction
     * @return void
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * Returns the number of this transaction
     * 
	 * @return string The number of this transaction
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Sets the number of this transaction
     * 
	 * @param string $number: The number of this transaction
     * @return void
     */
    public function setNumber($number) {
        $this->number = $number;
    }

    /**
     * Returns the date for which this transaction was posted
     * 
	 * @return \DateTime The post date of this transaction
     */
    public function getPostDate() {
        return $this->postDate;
    }

    /**
     * Sets the date for which this transaction was posted
     * 
	 * @param string $postDate: The post date for this transaction
     * @return void
     */
    public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }

    /**
     * Returns the date at which this transaction was entered
     * 
	 * @return \DateTime The entry date of this transaction
     */
    public function getEnterDate() {
        return $this->enterDate;
    }

    /**
     * Sets the date at which this transaction was entered
     * 
	 * @param string $enterDate: The date at which this transaction was entered
     * @return void
     */
    public function setEnterDate($enterDate) {
        $this->enterDate = $enterDate;
    }

    /**
     * Returns the description for this transaction
     * 
	 * @return string The description for this transaction
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the description for this transaction
     * 
	 * @param string $description: The description for this transaction
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns the splits of this transaction
     *
     * @return Collection<\ThinkopenAt\Gnucash\Domain\Model\Split> The splits of this transaction
     */
    public function getSplits() {
        return $this->splits;
    }

    /**
     * Sets the splits of this transaction
     *
     * @param Collection<\ThinkopenAt\Gnucash\Domain\Model\Split> $splits: The splits of this transaction
     * @return void
     */
    public function setSplits(Collection $splits) {
        $this->splits = $splits;
    }

}

