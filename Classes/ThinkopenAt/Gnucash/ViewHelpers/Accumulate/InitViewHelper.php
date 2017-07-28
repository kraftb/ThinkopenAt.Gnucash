<?php
namespace ThinkopenAt\Gnucash\ViewHelpers\Accumulate;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper;

/**
 * Initializes/encloses an accumulation.
 *
 * @api
 */
class InitViewHelper extends AbstractAccumulateViewHelper {

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

	/*
     * Initializes/encloses an accumulation
	 *
	 * @param string $key: A key for the accumulation
	 * @return string The unmodified contents of the tag
	 * @api
	 */
	public function render($key) {
		$this->dataContainer->set('accumulate|' . $key, 0);
        $result = $this->renderChildren();
		return $result;
	}

}

