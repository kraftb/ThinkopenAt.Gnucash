<?php
namespace ThinkopenAt\Gnucash\Doctrine\Dbal\Types;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "ThinkopenAt.Gnucash".   *
 *                                                                        *
 *                                                                        */

use Doctrine\DBAL\Platforms\AbstractPlatform;

class FractionType extends \Doctrine\DBAL\Types\Type {

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'fraction';
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return $platform->getFloatDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
echo "testX:$value: .. ";
        $result = new \ThinkopenAt\Gnucash\Domain\Type\Fraction($value);
		echo "ID: " . \TYPO3\Flow\Reflection\ObjectAccess::getProperty($result, 'Persistence_Object_Identifier', TRUE). " / ";
        $GLOBALS['debug'] = isset($GLOBALS['debug']) ? $GLOBALS['debug'] + 1 : 0;
if ($GLOBALS['debug'] > 5) {
    exit();
}
        return $result;
    }

}

