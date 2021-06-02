<?php


namespace Bancario\Modules\Trader\UI\Http\CommandMappers;

use Bancario\Modules\Trader\Application\Commands\IncreaseAttributeCommand;
use Bancario\Modules\Trader\Domain\TraderId;
use Illuminate\Http\Request;

class IncreaseAttributeCommandMapper
{
    public function map(string $traderId, Request $request): IncreaseAttributeCommand
    {
        return new IncreaseAttributeCommand(
            TraderId::fromString($traderId),
            $request->input('attribute')
        );
    }
}
