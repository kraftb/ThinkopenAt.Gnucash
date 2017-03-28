<?php
namespace ThinkopenAt\Gnucash\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * This domain model represents a currency.
 *
 * @Flow\Entity
 */
class Currency extends AbstractGnucashModel {

	/**
	 * Namespace of the currency
	 *
	 * @var string
	 */	
	protected $namespace = '';

	/**
	 * Short mnemonic of the currency
	 *
	 * @var string
	 */	
	protected $mnemonic = '';

	/**
	 * Full name of the currency
	 *
	 * @var string
	 */	
	protected $fullname = '';

	/**
	 * Cusip for the currency
	 *
	 * @var string
	 */	
	protected $cusip = '';

	/**
	 * Fraction for the currency
	 *
	 * @var integer
	 */	
	protected $fraction = 0;

	/**
	 * Quote flag for the currency
	 *
	 * @var integer
	 */	
	protected $quoteFlag = 0;

	/**
	 * Quote source for the currency
	 *
	 * @var string
	 */	
	protected $quoteSource = '';

	/**
	 * Quote TZ for the currency
	 *
	 * @var string
	 */	
	protected $quoteTz = '';


    /**
     * Returns namespace of the currency
     *
     * @return string Namespace of the currency
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * Sets namespace of the currency
     *
     * @param string $namespace: Namespace of the currency
     * @return void
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * Returns short mnemonic of the currency
     *
     * @return string Short mnemonic of the currency
     */
    public function getMnemonic() {
        return $this->mnemonic;
    }

    /**
     * Sets short mnemonic of the currency
     *
     * @param string $mnemonic: Short mnemonic of the currency
     * @return void
     */
    public function setMnemonic($mnemonic) {
        $this->mnemonic = $mnemonic;
    }

    /**
     * Returns full name of the currency
     *
     * @return string Full name of the currency
     */
    public function getFullname() {
        return $this->fullname;
    }

    /**
     * Sets full name of the currency
     *
     * @param string $fullname: Full name of the currency
     * @return void
     */
    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    /**
     * Returns cusip for the currency
     *
     * @return string Cusip for the currency
     */
    public function getCusip() {
        return $this->cusip;
    }

    /**
     * Sets cusip for the currency
     *
     * @param string $cusip: Cusip for the currency
     * @return void
     */
    public function setCusip($cusip) {
        $this->cusip = $cusip;
    }

    /**
     * Returns fraction for the currency
     *
     * @return integer Fraction for the currency
     */
    public function getFraction() {
        return $this->fraction;
    }

    /**
     * Sets fraction for the currency
     *
     * @param integer $fraction: Fraction for the currency
     * @return void
     */
    public function setFraction($fraction) {
        $this->fraction = $fraction;
    }

    /**
     * Returns quote flag for the currency
     *
     * @return integer Quote flag for the currency
     */
    public function getQuoteFlag() {
        return $this->quoteFlag;
    }

    /**
     * Sets quote flag for the currency
     *
     * @param integer $quoteFlag: Quote flag for the currency
     * @return void
     */
    public function setQuoteFlag($quoteFlag) {
        $this->quoteFlag = $quoteFlag;
    }

    /**
     * Returns quote source for the currency
     *
     * @return string Quote source for the currency
     */
    public function getQuoteSource() {
        return $this->quoteSource;
    }

    /**
     * Sets quote source for the currency
     *
     * @param string $quoteSource: Quote source for the currency
     * @return void
     */
    public function setQuoteSource($quoteSource) {
        $this->quoteSource = $quoteSource;
    }

    /**
     * Returns quote TZ for the currency
     *
     * @return string Quote TZ for the currency
     */
    public function getQuoteTz() {
        return $this->quoteTz;
    }

    /**
     * Sets quote TZ for the currency
     *
     * @param string $quoteTz: Quote TZ for the currency
     * @return void
     */
    public function setQuoteTz($quoteTz) {
        $this->quoteTz = $quoteTz;
    }

}

