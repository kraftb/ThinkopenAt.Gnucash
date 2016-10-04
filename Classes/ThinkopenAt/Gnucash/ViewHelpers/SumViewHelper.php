<?php
namespace ThinkopenAt\Gnucash\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper;

/**
 * This ViewHelper will sum up the given values.
 * = Examples =
 *
 * <code title="Build sum">
 * <gc:sum>123 + 456 + 1</gc:sum>
 * </code>
 * <output>580</output>
 *
 * @api
 */
class SumViewHelper extends AbstractViewHelper {

	/*
     * Sum up value
	 *
	 * @param string $separator: When not set "+" will get used as separator
	 * @return string The sum of the given values
	 * @api
	 */
	public function render($separator = '+') {
        $value = $this->renderChildren();
        $parts = explode($separator, $value);
        $sum = 0;
        foreach ($parts as $part) {
            $part = trim($part);
            @list($x, $postComma1) = explode('.', $part);
            @list($x, $postComma2) = explode('.', $sum);
            $max = max(strlen($postComma1), strlen($postComma2));
            $sum = bcadd($sum, $part, $max);
        }
		return $sum;
	}

}

