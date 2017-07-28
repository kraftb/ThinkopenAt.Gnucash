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
class AddViewHelper extends AbstractAccumulateViewHelper {

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
	 * @param string $key: A key to which to add the value
	 * @param string $value: The value which to add to the given accu. If not set the tag contents are used.
	 * @param boolean $returnValue: When true the $value will also get returned.
	 * @return string Either an empty string of the contents of $value if "returnValue" is set.
	 * @api
	 */
	public function render($key, $value = '', $returnValue = false) {
		if ($value === '') {
        	$value = $this->renderChildren();
		}

		$accu = $this->dataContainer->get('accumulate|' . $key);
		$accu += $value;
		$this->dataContainer->set('accumulate|' . $key, $accu);

		if ($returnValue) {
			return $value;
		} else {
			return '';
		}
	}

}

