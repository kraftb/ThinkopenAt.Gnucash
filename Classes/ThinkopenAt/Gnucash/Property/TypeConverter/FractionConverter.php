<?php
namespace ThinkopenAt\Gnucash\Property\TypeConverter;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Converter which transforms from string and integer to
 * an \ThinkopenAt\Gnucash\Domain\Type\Fraction object.
 *
 * @api
 * @Flow\Scope("singleton")
 */
class FractionConverter extends \TYPO3\Flow\Property\TypeConverter\AbstractTypeConverter {

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Object\ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * @var array<string>
     */
    protected $sourceTypes = array('string', 'integer', 'double', 'float');

    /**
     * @var string
     */
    protected $targetType = 'ThinkopenAt\Gnucash\Domain\Type\Fraction';

    /**
     * @var integer
     */
    protected $priority = 80;

    /**
     * If conversion is possible.
     *
     * @param string $source
     * @param string $targetType
     * @return boolean
     */
    public function canConvertFrom($source, $targetType) {
        if ($targetType !== \ThinkopenAt\Gnucash\Domain\Type\Fraction::class) {
            return false;
        }
        return is_numeric($source);
    }

    /**
     * Converts $source to a "Fraction" simply by instanciating the "Fraction"
     * and passing the value to the constructor.
     *
     * @param string|integer|double|float $source The value to be converted to a "Fraction" object
     * @param string $targetType must be "\ThinkopenAt\Gnucash\Domain\Type\Fraction"
     * @param array $convertedChildProperties not used currently
     * @param \TYPO3\Flow\Property\PropertyMappingConfigurationInterface $configuration
     * @return \ThinkopenAt\Gnucash\Domain\Type\Fraction The converted value
     * @throws \TYPO3\Flow\Property\Exception\TypeConverterException
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \TYPO3\Flow\Property\PropertyMappingConfigurationInterface $configuration = null) {
        $value = (string)$source;
        $value = str_replace(',', '.', $value);
        $result = $this->objectManager->get(\ThinkopenAt\Gnucash\Domain\Type\Fraction::class, $value);
        return $result;
    }

}

