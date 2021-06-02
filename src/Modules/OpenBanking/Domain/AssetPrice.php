<?php declare(strict_types=1);


namespace Bancario\Modules\OpenBanking\Domain;


use Webmozart\Assert\Assert;

class AssetPrice
{
    /**
     * @var int
     */
    private $amount;

    private function __construct(int $amount)
    {
        Assert::greaterThanEq($amount, 0, 'Asset price must be greater or equal to 0');

        $this->amount = $amount;
    }

    public static function ofAmount(int $amount): self
    {
        return new self($amount);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
