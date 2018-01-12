<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents the currency of an invoice
 *
 * @Flow\Entity
 */
class Currency {

	/**
	 * Namespace of this currency (usually "CURRENCY")
	 *
	 * @var string
	 */	
	protected $namespace = '';

	/**
	 * Mnemonic of this currency
	 *
	 * @var string
	 */	
	protected $mnemonic = '';

	/**
	 * Full name for this currency
	 *
	 * @var string
	 */	
	protected $fullName = '';

	/**
	 * Cusip (?)
	 *
	 * @var string
	 */	
	protected $cusip = '';

	/**
	 * Fraction of the currency
	 *
	 * @var integer
	 */	
	protected $fraction = 0;

	/**
	 * Quote flag (?)
	 *
	 * @var boolean
	 */	
	protected $quoteFlag = 0;

	/**
	 * Quote source (?)
	 *
	 * @var string
	 */	
	protected $quoteSource = '';

	/**
	 * Quote timezone
	 *
	 * @var string
	 */	
	protected $quoteTimeZone = '';


    /**
     * Returns namespace of this currency (usually "CURRENCY")
     *
     * @return string Namespace of this currency (usually "CURRENCY")
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * Sets namespace of this currency (usually "CURRENCY")
     *
     * @param string $namespace: Namespace of this currency (usually "CURRENCY")
     * @return void
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * Returns mnemonic of this currency
     *
     * @return string Mnemonic of this currency
     */
    public function getMnemonic() {
        return $this->mnemonic;
    }

    /**
     * Sets mnemonic of this currency
     *
     * @param string $mnemonic: Mnemonic of this currency
     * @return void
     */
    public function setMnemonic($mnemonic) {
        $this->mnemonic = $mnemonic;
    }

    /**
     * Returns full name for this currency
     *
     * @return string Full name for this currency
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * Sets full name for this currency
     *
     * @param string $fullName: Full name for this currency
     * @return void
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    /**
     * Returns cusip (?)
     *
     * @return string Cusip (?)
     */
    public function getCusip() {
        return $this->cusip;
    }

    /**
     * Sets cusip (?)
     *
     * @param string $cusip: Cusip (?)
     * @return void
     */
    public function setCusip($cusip) {
        $this->cusip = $cusip;
    }

    /**
     * Returns fraction of the currency
     *
     * @return integer Fraction of the currency
     */
    public function getFraction() {
        return $this->fraction;
    }

    /**
     * Sets fraction of the currency
     *
     * @param integer $fraction: Fraction of the currency
     * @return void
     */
    public function setFraction($fraction) {
        $this->fraction = $fraction;
    }

    /**
     * Returns quote flag (?)
     *
     * @return boolean Quote flag (?)
     */
    public function getQuoteFlag() {
        return $this->quoteFlag;
    }

    /**
     * Sets quote flag (?)
     *
     * @param boolean $quoteFlag: Quote flag (?)
     * @return void
     */
    public function setQuoteFlag($quoteFlag) {
        $this->quoteFlag = $quoteFlag;
    }

    /**
     * Returns quote source (?)
     *
     * @return string Quote source (?)
     */
    public function getQuoteSource() {
        return $this->quoteSource;
    }

    /**
     * Sets quote source (?)
     *
     * @param string $quoteSource: Quote source (?)
     * @return void
     */
    public function setQuoteSource($quoteSource) {
        $this->quoteSource = $quoteSource;
    }

    /**
     * Returns quote timezone
     *
     * @return string Quote timezone
     */
    public function getQuoteTimeZone() {
        return $this->quoteTimeZone;
    }

    /**
     * Sets quote timezone
     *
     * @param string $quoteTimeZone: Quote timezone
     * @return void
     */
    public function setQuoteTimeZone($quoteTimeZone) {
        $this->quoteTimeZone = $quoteTimeZone;
    }

}

