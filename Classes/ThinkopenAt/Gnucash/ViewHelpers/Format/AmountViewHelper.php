<?php
namespace ThinkopenAt\Gnucash\ViewHelpers\Format;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper;

/**
 * This ViewHelper will format an amount.
 * It will usually display every amount with "precision" digits after
 * the comma. Only if there are more than "precision" non-zero digits
 * after the comma they will get displayed.
 *
 * <code title="Format amount value #1">
 * <gc:format.amount>123.0000000</gc:format.amount>
 * </code>
 * <output>123.00</output>
 *
 * <code title="Format amount value #2">
 * <gc:format.amount>123.4500000</gc:format.amount>
 * </code>
 * <output>123.45</output>
 *
 * <code title="Format amount value #3">
 * <gc:format.amount>123</gc:format.amount>
 * </code>
 * <output>123.00</output>
 *
 * <code title="Format amount value #4">
 * <gc:format.amount>123.456</gc:format.amount>
 * </code>
 * <output>123.456</output>
 *
 * <code title="Format amount value #5">
 * <gc:format.amount precision="4">123</gc:format.amount>
 * </code>
 * <output>123.0000</output>
 *
 * @api
 */
class AmountViewHelper extends AbstractViewHelper {

	/*
     * Format invoice entry description
	 *
	 * @param integer $precision: How many digits after the comma
	 * @return string The formatted value/children
	 * @api
	 */
	public function render($precision = 2) {
		$precision = (int)$precision;
        $value = trim($this->renderChildren());
		$parts = explode('.', $value, 2);
		$base = $parts[0];
		$fraction = '';
		if (count($parts) > 1) {
			$fraction = $parts[1];
		}
		$fraction = rtrim($fraction, '0');

		if ($precision === 0 && !strlen($fraction)) {
			return (int)$base;
		} else {
			$fraction = str_pad($fraction, $precision, '0', STR_PAD_RIGHT);
			return (int)$base . '.' . $fraction;
		}
	}

}

