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
 * <gc:math>123 + 456 * 3</gc:math>
 * </code>
 * <output>1491</output>
 *
 * @api
 */
class MathViewHelper extends AbstractViewHelper {

	/*
     * Perform arithmetic operations
	 *
	 * @param string $expression: Expression which to evaluate. If not set the tag-contents (children) will get evaluated.
	 * @return string The evaluated expression
	 * @api
	 */
	public function render($expression = '') {
		if ($expression === '') {
	        $expression = $this->renderChildren();
		}
		$expression = preg_replace('/[^0-9\*\+\-\/\s\(\)\.]/', '', $expression);
	
		// We assume "bc" is executable.	
		exec('echo "'.$expression.'" | bc', $output, $result);

		return $output[0];
	}

}

