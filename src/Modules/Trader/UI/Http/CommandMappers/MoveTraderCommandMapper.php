<?php


namespace Bancario\Modules\Trader\UI\Http\CommandMappers;

use Bancario\Modules\Trader\Application\Commands\MoveTraderCommand;
use Bancario\Modules\Trader\Domain\TraderId;

class MoveTraderCommandMapper
{
    public function map(string $traderId, string $locationId): MoveTraderCommand
    {
        return new MoveTraderCommand(
            TraderId::fromString($traderId),
            $locationId
        );
    }
}
