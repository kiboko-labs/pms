<?php

namespace Kiboko\Component\Pricing\Type\DBAL;

use Brick\Math\BigNumber as BrickBigNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BigNumber extends Type
{
    const BIG_NUMBER = 'big_number';

    /**
     * @return string
     */
    public function getName()
    {
        return self::BIG_NUMBER;
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
        return BrickBigNumber::of($value);
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
