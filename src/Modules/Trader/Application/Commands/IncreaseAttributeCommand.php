<?php


namespace Bancario\Modules\Trader\Application\Commands;


use Bancario\Modules\Trader\Domain\TraderId;

class IncreaseAttributeCommand
{
    /**
     * @var TraderId
     */
    private $traderId;
    /**
     * @var string
     */
    private $attribute;

    public function __construct(TraderId $traderId, string $attribute)
    {
        $this->traderId = $traderId;
        $this->attribute = $attribute;
    }

    public function getTraderId(): TraderId
    {
        return $this->traderId;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }
}
