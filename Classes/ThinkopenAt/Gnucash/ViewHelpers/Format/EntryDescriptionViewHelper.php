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
 * This ViewHelper will format an invoice entry descritpion.
 * The special character combination ";;" is translated to a newline
 * for whatever output media we are rendering currently
 *
 * <code title="Format invoice entry description">
 * <gc:format.entryDescription>Implemented new feature;;Commited to git</gc:format.entryDescription>
 * </code>
 * <output>
 * Implemented new feature
 * Commited to git
 * </output>
 *
 * @api
 */
class EntryDescriptionViewHelper extends AbstractViewHelper {

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

	/*
     * Format invoice entry description
	 *
	 * @param string $newline: Which character/string to use as newline character. Could be "<br />" for HTML
	 * @return string The formatted value/children
	 * @api
	 */
	public function render($newline = "\n") {
        $value = $this->renderChildren();
		$value = str_replace(';;', $newline, $value);
		return $value;
	}

}

