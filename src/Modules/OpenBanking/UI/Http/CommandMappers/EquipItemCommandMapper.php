<?php

namespace Bancario\Modules\OpenBanking\UI\Http\CommandMappers;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Application\Commands\EquipAssetCommand;
use Illuminate\Http\Request;
use Bancario\Models\Trader\User as UserModel;

class EquipAssetCommandMapper
{
    public function map(Request $request): EquipAssetCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new EquipAssetCommand(
            AssetCode::fromString((string)$request->route('asset')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
