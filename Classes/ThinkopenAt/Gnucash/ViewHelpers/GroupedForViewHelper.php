<?php
namespace ThinkopenAt\Gnucash\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 * This script is mostly a copy of the TYPO3 Flow                         *
 * package "TYPO3.Fluid" view helper "groupdeFor                          *
 *                                                                        */

/*                                                                        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Reflection\ObjectAccess;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper;

/**
 * Examples: See "f:groupedFor".
 * The only difference is a new argument "index" which defines the name of
 * a variable which contains an index (starting at 1) for counting the
 * number of groups.
 *
 * @api
 */
class GroupedForViewHelper extends \TYPO3\Fluid\ViewHelpers\GroupedForViewHelper {

	/**
	 * Iterates through elements of $each and renders child nodes
	 *
	 * @param array $each The array or \SplObjectStorage to iterated over
	 * @param string $as The name of the iteration variable
	 * @param string $groupBy Group by this property
	 * @param string $groupKey The name of the variable to store the current group
	 * @return string Rendered string
	 * @throws ViewHelper\Exception
	 * @api
	 */
	public function render($each, $as, $groupBy, $groupKey = 'groupKey', $index = '') {
		$output = '';
		if ($each === NULL) {
			return '';
		}
		if (is_object($each)) {
			if (!$each instanceof \Traversable) {
				throw new ViewHelper\Exception('GroupedForViewHelper only supports arrays and objects implementing \Traversable interface', 1253108907);
			}
			$each = iterator_to_array($each);
		}

		$groups = $this->groupElements($each, $groupBy);

        $count = 0;
		foreach ($groups['values'] as $currentGroupIndex => $group) {
            $count++;
            if ($index) {
			    $this->templateVariableContainer->add($index, $count);
            }
			$this->templateVariableContainer->add($groupKey, $groups['keys'][$currentGroupIndex]);
			$this->templateVariableContainer->add($as, $group);
			$output .= $this->renderChildren();
            if ($index) {
			    $this->templateVariableContainer->remove($index);
            }
			$this->templateVariableContainer->remove($groupKey);
			$this->templateVariableContainer->remove($as);
		}
		return $output;
	}

}
