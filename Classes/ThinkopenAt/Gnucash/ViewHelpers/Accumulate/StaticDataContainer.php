<?php
namespace ThinkopenAt\Gnucash\ViewHelpers\Accumulate;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash". *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Container for accumulation data
 *
 * @Flow\Scope("singleton")
 */
class StaticDataContainer  {

	/**
	 * The accumulated data
	 *
	 * @var array
	 */
	protected $data = array();


	/**
	 * Returns the given key from the data array
	 *
	 * @param string $key: The key which to return
	 * @return mixed The data contained in the key
	 */
	public function get($key) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} else {
			return null;
		}
	}

	/**
	 * Sets the given key in the data array
	 *
	 * @param string $key: The key which to set
	 * @param mixed $value: The value which to set
	 * @return void
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}

}

