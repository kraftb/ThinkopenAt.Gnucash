<?php
namespace ThinkopenAt\Gnucash\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
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
 * <code title="Determine whether a value is negative">
 * <gc:isNegative>-123.40</gc:isNegative>
 * </code>
 * <output>1</output>
 *
 * <code title="Determine whether a value is negative">
 * <gc:isNegative>123.40</gc:isNegative>
 * </code>
 * <output>0</output>
 *
 * @api
 */
class IsNegativeViewHelper extends AbstractViewHelper {

	/**
     * Determine whether the contained value is negative
	 *
	 * @return boolean Returns true if the passed value is negative
	 * @api
	 */
	public function render() {
        $value = trim($this->renderChildren());
        if (substr($value, 0, 1) === '-') {
            return true;
        }
		return false;
	}

}

