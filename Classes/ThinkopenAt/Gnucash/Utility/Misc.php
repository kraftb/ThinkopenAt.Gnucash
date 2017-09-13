<?php
namespace ThinkopenAt\Gnucash\Utility;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

class Misc {

	/**
	 * Returns the requested part of the comma separated value
	 *
	 */
	public function getPipePart($part, $value) {
		if (is_numeric($part)) {
			$parts = explode('|', $value);
			$result = $parts[$part];
		} else {
			$expression = '/(^|\\|)' . preg_quote($part) . ':([^|]*)($|\\|)/';
			$result = '';
			if (preg_match($expression, $value, $matches)) {
				$result = $matches[2];
			}
		}
		return $result;
	}

}

