<?php
namespace ThinkopenAt\Gnucash\Domain\Dto;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This data transfer object represents an bill entry (line/split)
 * and is used to transfer data from the form to the domain model
 * which will get persisted.
 *
 * @Flow\Entity
 */
class BillEntry {

	/**
	 * The bill for this entry.
	 *
	 * @var \ThinkopenAt\Gnucash\Domain\Dto\Bill
     * @Flow\Transient
	 */	
	protected $bill = NULL;

	/**
	 * Index of this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $index = 0;

	/**
	 * Description for this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $description = '';

	/**
	 * Quantity of this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $quantity = '';

	/**
	 * Action for this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $action = '';

	/**
	 * Price of this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $price = '';

	/**
	 * Price unit of this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $priceUnit = '';

	/**
	 * Net amount of this bill/invoice entry
	 *
	 * @var string
	 */	
	protected $net = '';


    /**
     * Returns the bill for this entry.
     *
     * @return \ThinkopenAt\Gnucash\Domain\Dto\Bill The bill for this entry
     */
    public function getBill() {
        return $this->bill;
    }

    /**
     * Sets the bill for this entry.
     *
     * @param \ThinkopenAt\Gnucash\Domain\Dto\Bill $bill: The bill for this entry
     * @return void
     */
    public function setBill(\ThinkopenAt\Gnucash\Domain\Dto\Bill $bill) {
        $this->bill = $bill;
    }

    /**
     * Returns index of this bill/invoice entry
     *
     * @return string Index of this bill/invoice entry
     */
    public function getIndex() {
        return $this->index;
    }

    /**
     * Sets index of this bill/invoice entry
     *
     * @param string $index: Index of this bill/invoice entry
     * @return void
     */
    public function setIndex($index) {
        $this->index = $index;
    }

    /**
     * Returns description for this bill/invoice entry
     *
     * @return string Description for this bill/invoice entry
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets description for this bill/invoice entry
     *
     * @param string $description: Description for this bill/invoice entry
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns quantity of this bill/invoice entry
     *
     * @return string Quantity of this bill/invoice entry
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Sets quantity of this bill/invoice entry
     *
     * @param string $quantity: Quantity of this bill/invoice entry
     * @return void
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    /**
     * Returns action for this bill/invoice entry
     *
     * @return string Action for this bill/invoice entry
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Sets action for this bill/invoice entry
     *
     * @param string $action: Action for this bill/invoice entry
     * @return void
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * Returns price of this bill/invoice entry
     *
     * @return string Price of this bill/invoice entry
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Sets price of this bill/invoice entry
     *
     * @param string $price: Price of this bill/invoice entry
     * @return void
     */
    public function setPrice($price) {
        $this->price = $price;
    }

    /**
     * Returns price unit of this bill/invoice entry
     *
     * @return string Price unit of this bill/invoice entry
     */
    public function getPriceUnit() {
        return $this->priceUnit;
    }

    /**
     * Sets price unit of this bill/invoice entry
     *
     * @param string $priceUnit: Price unit of this bill/invoice entry
     * @return void
     */
    public function setPriceUnit($priceUnit) {
        $this->priceUnit = $priceUnit;
    }

    /**
     * Returns net amount of this bill/invoice entry
     *
     * @return string Net amount of this bill/invoice entry
     */
    public function getNet() {
        return $this->net;
    }

    /**
     * Sets net amount of this bill/invoice entry
     *
     * @param string $net: Net amount of this bill/invoice entry
     * @return void
     */
    public function setNet($net) {
        $this->net = $net;
    }

}

