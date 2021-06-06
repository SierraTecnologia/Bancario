<?php

namespace Bancario\Modules\OpenBanking\UI\Http\CommandMappers;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;
use Bancario\Modules\OpenBanking\Application\Commands\CreateAssetCommand;
use Illuminate\Http\Request;
use Bancario\Models\Trader\User as UserModel;

class CreateAssetCommandMapper
{
    public function map(Request $request): CreateAssetCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new CreateAssetCommand(
            AssetPrototypeId::fromString($request->input('prototype_asset_id')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
