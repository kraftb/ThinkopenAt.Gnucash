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
 * <code title="Get code part">
 * <gc:codePart code="VAT">VAT:EU|BMD:12345</gc:codePart>
 * </code>
 * <output>EU</output>
 *
 * @api
 */
class CodePartViewHelper extends AbstractViewHelper {

    /**
     * Instance of the "misc" utility
     *
     * @Flow\Inject
     * @var \ThinkopenAt\Gnucash\Utility\Misc
     */
    protected $misc = NULL;

	/*
     * Retrieve a code part from the given argument/content
	 *
	 * @param string $code: Code part which to return
	 * @param string $value: Value from which to retrieve code part. If not given tag contents will be used.
	 * @return string The requested code part or an empty string
	 * @api
	 */
	public function render($code, $value= '') {
		if ($value === '') {
	        $value = $this->renderChildren();
		}
		return $this->misc->getPipePart($code, $value);
	}

}

