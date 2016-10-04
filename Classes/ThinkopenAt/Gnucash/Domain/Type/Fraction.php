<?php
namespace ThinkopenAt\Gnucash\Domain\Type;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * This type represents a fraction and thus a number in Q.
 */
class Fraction {

	/**
	 * The numerator of the fraction (value above the fraction line)
	 *
	 * @var integer
	 */	 
	protected $numerator = 0;

	/**
	 * The denominator of the fraction (value below the fraction line)
	 *
	 * @var integer
	 */	 
	protected $denominator = 0;

    /**
     * Constructor for this value object
     * 
	 * @param integer $numerator: Will receive the numerator
	 * @param integer $denominator: Will receive the denominator
     */
    public function __construct($numerator, $denominator) {
        $this->numerator = (int)$numerator;
        $this->denominator = (int)$denominator;
    }

    /**
     * Returns the numerator of the fraction
     * 
	 * @return integer The numerator of the fraction
     */
    public function getNumerator() {
        return $this->numerator;
    }

    /**
     * Returns the denominator of the fraction
     * 
	 * @return integer The denominator of the fraction
     */
    public function getDenominator() {
        return $this->denominator;
    }

    /**
     * Returns value of the fraction as float
     * 
	 * @return float The fraction value
     */
    public function toFloat() {
        return (float)$this->numerator / (float)$this->denominator;
    }

    /**
     * Add the given fraction to this fraction
     * 
     * @param \ThinkopenAt\Gnucash\Domain\Type\Fraction $value: The fraction value which to add
	 * @return float The fraction value
     */
    public function add(\ThinkopenAt\Gnucash\Domain\Type\Fraction $value) {
        if ($this->getNumerator() === 0 && $this->getDenominator() === 0) {
            $this->numerator = $value->getNumerator();
            $this->denominator = $value->getDenominator();
        } else {
                if ($this->getDenominator() === $value->getDenominator()) {
                    $this->numerator += $value->getNumerator();
                } elseif ($this->getDenominator() > $value->getDenominator()) {
                    $factor = $this->getDenominator() / $value->getDenominator();
                    $this->numerator += $value->getNumerator() * $factor;
                } else {
                    $factor = $value->getDenominator() / $this->getDenominator();
                    $this->numerator *= $factor;
                    $this->numerator += $value->getNumerator();
                    $this->denomniator = $value->getDenominator();
                }
        }
    }

    /**
     * Returns a new fraction containing the current value as absolute (non negative) value
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The value converted to string
     */
    public function abs() {
        $result = clone($this);
        if ($result->getNumerator() < 0) {
            $result->numerator = -$result->getNumerator();
        }
        return $result;
    }

    /**
     * Allows to determine whether this value is positive (>= 0)
     * 
	 * @return boolean Returns TRUE when the value is positive
     */
    public function isPositive() {
        if ($this->getNumerator() < 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Converts this fraction to a string value
     * 
	 * @return string The value converted to string
     */
    public function __toString() {
        if ($this->getDenominator()%10 === 0) {
            $value = (string)$this->getNumerator();
            $exp = round(log($this->getDenominator())/log(10));
            return substr($value, 0, -$exp) . '.' . substr($value, -$exp);
        } else {
            return (string)$this->toFloat();
        }
    }

}

