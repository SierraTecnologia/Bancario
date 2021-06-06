<?php


namespace Bancario\Modules\Trader\Application\Commands;


class CreateTraderCommand
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $exchangeCode;
    /**
     * @var bool
     */
    private $isBacktest;

    public function __construct(string $name, string $exchangeCode, bool $isBacktest = true)
    {
        $this->name = $name;
        $this->exchangeCode = $exchangeCode;
        $this->isBacktest = $isBacktest;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExchangeCode(): string
    {
        return $this->exchangeCode;
    }

    public function getIsBacktest(): bool
    {
        return $this->isBacktest;
    }
}
