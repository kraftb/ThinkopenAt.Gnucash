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
 * This ViewHelper will sum up a field of the contained "Split" objects.
 * The field is specified by the "field" parameter.
 *
 * = Examples =
 *
 * <code title="Sum up quantities">
 * <gc:accumulateSplits field="quantity">{splits}</gc:accumulateSplits>
 * </code>
 * <output>1234.56</output>
 *
 * @api
 */
class AccumulateSplitsViewHelper extends AbstractViewHelper {

	/*
     * Accumulate passed splits
	 *
	 * @param string $field: The field of the splits which to sum up. May either container integer/float values or "Fraction" objects
	 * @param boolean $abs: Whether to take the absolute value of each split-value
	 * @param string $sign: When set to "+" or "-" only positive/negative splits will get summed up.
	 * @param \ThinkopenAt\Gnucash\Domain\Model $splits: The splits which to sum up. If not specified use contents.
	 * @return string The sum of the given splits
	 * @api
	 */
	public function render($field, $abs = false, $sign = '', $splits = NULL) {
		if ($splits === NULL) {
            $splits = $this->renderChildren();
		}
        $sum = $this->objectManager->get('ThinkopenAt\Gnucash\Domain\Type\Fraction');

        switch ($field) {
            case 'quantity':
            case 'value':
                break;

            default:
                throw new \Exception('Invalid field "' . $field . '" for accumulation!');
        }

        $method = 'get' . ucfirst($field);
        foreach ($splits as $split) {
            $value = $split->$method();
            if ($sign === '+' && !$value->isPositive() || $sign === '-' && $value->isPositive()) {
                continue;
            }
            if ($abs) {
                $sum->add($value->abs());
            } else {
                $sum->add($value);
            }
        }
        $sum = (string)$sum;
        if (substr($sum, 0, 1) === '.') {
            $sum = '0' . $sum;
        }
		return $sum;
	}

}

