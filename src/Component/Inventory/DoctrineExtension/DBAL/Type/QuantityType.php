<?php

namespace Kiboko\Component\Inventory\DoctrineExtension\DBAL\Type;

use Brick\Math\BigNumber as BrickBigNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class QuantityType extends Type
{
    const QUANTITY = 'quantity';

    /**
     * @return string
     */
    public function getName()
    {
        return self::QUANTITY;
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDecimalTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
     * @return BrickBigNumber
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value !== null ? BrickBigNumber::of($value) : BrickBigNumber::of(0);
    }

    /**
     * @param BrickBigNumber $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
