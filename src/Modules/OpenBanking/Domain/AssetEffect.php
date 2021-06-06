<?php

namespace Bancario\Modules\OpenBanking\Domain;


use InvalidArgumentException;

class AssetEffect
{
    public const NONE = 'none';
    public const DAMAGE = 'damage';
    public const ARMOR = 'armor';
    public const PRECISION = 'precision';
    public const EVASION = 'evasion';
    public const TRICKERY = 'evasion';
    public const AWARENESS = 'awareness';

    public const TYPES = [
        self::NONE,
        self::DAMAGE,
        self::ARMOR,
        self::PRECISION,
        self::EVASION,
        self::TRICKERY,
        self::AWARENESS,
    ];

    /**
     * @var int
     */
    private $quantity;
    /**
     * @var string
     */
    private $type;

    private function __construct(int $quantity, string $type)
    {
        $this->quantity = $quantity;
        $this->type = $type;
    }

    public static function ofType(int $quantity, string $type): AssetEffect
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("$type is not a valid Asset Effect type");
        }

        return new self($quantity, $type);
    }

    public static function damage(int $quantity): AssetEffect
    {
        return new self($quantity, self::DAMAGE);
    }

    public static function armor(int $quantity): AssetEffect
    {
        return new self($quantity, self::ARMOR);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
