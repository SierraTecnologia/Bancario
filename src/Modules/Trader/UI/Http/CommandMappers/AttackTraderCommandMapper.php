<?php


namespace Bancario\Modules\Trader\UI\Http\CommandMappers;

use Bancario\Modules\Trader\Application\Commands\AttackTraderCommand;
use Bancario\Modules\Trader\Domain\TraderId;
use Bancario\Models\Trader\User as UserModel;
use Illuminate\Http\Request;

class AttackTraderCommandMapper
{
    public function map(Request $request, string $defenderId): AttackTraderCommand
    {
        /** @var UserModel $authenticatedUser */
        $userModel = $request->user();

        return new AttackTraderCommand(
            TraderId::fromString($userModel->trader->getId()),
            TraderId::fromString($defenderId)
        );
    }
}
