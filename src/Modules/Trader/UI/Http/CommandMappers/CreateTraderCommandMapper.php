<?php
/**
 * @todo
 */

namespace Bancario\Modules\Trader\UI\Http\CommandMappers;

use Bancario\Modules\Trader\Application\Commands\CreateTraderCommand;
use Illuminate\Http\Request;
use Bancario\Models\Trader\User as UserModel;

class CreateTraderCommandMapper
{
    public function map(Request $request): CreateTraderCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new CreateTraderCommand(
            $request->input('name'),
            $request->input('gender'),
            $request->input('exchange_code'),
            $userModel->getId()
        );
    }
}
