<?php

namespace Bancario\Modules\OpenBanking\UI\Http\CommandMappers;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Application\Commands\AddAssetToInventoryCommand;
use Illuminate\Http\Request;
use Bancario\Models\Trader\User as UserModel;

class AddAssetToInventoryCommandMapper
{
    public function map(Request $request): AddAssetToInventoryCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new AddAssetToInventoryCommand(
            CharacterId::fromString($userModel->character->getId()),
            (int)$request->input('inventory_slot'),
            AssetCode::fromString((string)$request->input('asset_id'))
        );
    }
}
