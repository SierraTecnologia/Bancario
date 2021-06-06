<?php

namespace Bancario\Modules\OpenBanking\Domain;

use InvalidArgumentException;

class AssetType
{
    public const MISCELLANEOUS = 'miscellaneous';
    public const HEAD_GEAR = 'head_gear';
    public const BODY_ARMOR = 'body_armor';
    public const MAIN_HAND = 'main_hand';
    public const OFF_HAND = 'off_hand';

    public const TYPES = [
        self::MISCELLANEOUS,
        self::HEAD_GEAR,
        self::BODY_ARMOR,
        self::MAIN_HAND,
        self::OFF_HAND,
    ];

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function ofType(string $type): AssetType
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("$type is not a valid Asset Type");
        }

        return new self($type);
    }

    public static function headGear(): AssetType
    {
        return new self(self::HEAD_GEAR);
    }

    public static function bodyArmor(): AssetType
    {
        return new self(self::BODY_ARMOR);
    }

    public static function mainHand(): AssetType
    {
        return new self(self::MAIN_HAND);
    }

    public static function offHand(): AssetType
    {
        return new self(self::OFF_HAND);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function equals(AssetType $type): bool
    {
        return $this->type === $type->toString();
    }
}
