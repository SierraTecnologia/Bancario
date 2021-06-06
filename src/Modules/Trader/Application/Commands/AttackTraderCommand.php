<?php


namespace Bancario\Modules\Trader\Application\Commands;


use Bancario\Modules\Trader\Domain\TraderId;

class AttackTraderCommand
{
    /**
     * @var TraderId
     */
    private $attackerId;
    /**
     * @var TraderId
     */
    private $defenderId;

    public function __construct(TraderId $attackerId, TraderId $defenderId)
    {
        $this->attackerId = $attackerId;
        $this->defenderId = $defenderId;
    }

    public function getAttackerId(): TraderId
    {
        return $this->attackerId;
    }

    public function getDefenderId(): TraderId
    {
        return $this->defenderId;
    }
}
