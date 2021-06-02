<?php


namespace Bancario\Modules\Trader\Application\Commands;


use Bancario\Modules\Trader\Domain\TraderId;

class MoveTraderCommand
{
    /**
     * @var TraderId
     */
    private $traderId;

    /**
     * @var string
     */
    private $locationId;

    public function __construct(TraderId $traderId, string $locationId)
    {
        $this->traderId = $traderId;
        $this->locationId = $locationId;
    }

    public function getTraderId(): TraderId
    {
        return $this->traderId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}
