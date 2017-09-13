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
    public function __construct($numerator = '', $denominator = '') {
        if (strpos($numerator, '.') !== false) {
            $this->fromString($numerator);
        } else {
            $this->numerator = (int)$numerator;
            $this->denominator = (int)$denominator;
            if (!$this->denominator) {
                $this->denominator = 1;
            }
        }
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
     * Sets the numerator of the fraction
     * 
	 * @param integer $numerator: Sets numerator of the fraction
	 * @return void
     */
    public function setNumerator($numerator) {
        $this->numerator = (int)$numerator;
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
     * Sets the denominator of the fraction
     * 
	 * @return integer $denominator: The denominator of the fraction
     */
    public function setDenominator($denominator) {
        $this->denominator = (int)$denominator;
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
        if ($this->getNumerator() === 0) {
            // Current value is zero. Just set numerator/denominator from passed value
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
     * Returns a new fraction with inverted signs.
     * 
	 * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The inverted/negated value
     */
    public function negate() {
        $result = clone($this);
		$result->setNumerator(-$result->getNumerator());
		return $result;
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
     * Splits a string value into a fraction
     * 
	 * @param string $number: The value to be splitted/converted
	 * @return void
     */
    public function fromString($number) {
        list($full, $fraction) = explode('.', $number);
        $this->numerator = $full . $fraction;
        $this->denominator = '1' . str_repeat('0', strlen($fraction));
    }

    /**
     * Converts this fraction to a string value
     * 
	 * @return string The value converted to string
     */
    public function __toString() {
		$denominator = $this->getDenominator();
        if (preg_match('/^1(0*)$/', $denominator, $matches)) {
            $value = (string)$this->getNumerator();
			$zeros = strlen($matches[1]);
			$sign = '';
			if (substr($value, 0, 1) === '-') {
				$value = substr($value, 1);
				$sign = '-';
			}
			$preComma = substr($value, 0, -$zeros);
			$postComma = substr($value, -$zeros);
			if (strlen($preComma) === 0) {
				$preComma = '0';
			}
			if (strlen($postComma) < $zeros) {
				$postComma = str_pad($postComma, $zeros, '0', STR_PAD_LEFT);
			}
            return $sign . $preComma . '.' . $postComma;
        } else {
            return (string)$this->toFloat();
        }
    }

}

