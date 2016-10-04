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
 * This ViewHelper will sum up a field of the contained "Split" objects.
 * The field is specified by the "field" parameter.
 *
 * = Examples =
 *
 * <code title="Show absolute value">
 * <gc:absoluteValue>-123.40</gc:absoluteValue>
 * </code>
 * <output>123.40</output>
 *
 * @api
 */
class AbsoluteValueViewHelper extends AbstractViewHelper {

	/*
     * Accumulate passed splits
	 *
	 * @param string $field: The field of the splits which to sum up. May either container integer/float values or "Fraction" objects
	 * @param boolean $abs: Whether to take the absolute value of each split-value
	 * @param string $sign: When set to "+" or "-" only positive/negative splits will get summed up.
	 * @param \ThinkopenAt\Gnucash\Domain\Model $splits: The splits which to sum up. If not specified use contents.
	 * @return string The sum of the given splits
	 * @api
	 */
	public function render() {
        $value = trim($this->renderChildren());
        if (substr($value, 0, 1) === '-') {
            $value = trim(substr($value, 1));
        }
		return $value;
	}

}

