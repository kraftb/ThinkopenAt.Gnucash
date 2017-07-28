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
class GetViewHelper extends AbstractAccumulateViewHelper {

	/*
     * Returns the current value of an accu
	 *
	 * @param string $key: A key to which to retrieve
	 * @return mixed The current value of an accu
	 * @api
	 */
	public function render($key) {
		$accu = $this->dataContainer->get('accumulate|' . $key);
		return $accu;
	}

}

