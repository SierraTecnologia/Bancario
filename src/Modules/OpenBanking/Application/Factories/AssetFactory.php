<?php

namespace Bancario\Modules\OpenBanking\Application\Factories;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Domain\AssetPrototype;


class AssetFactory
{
    public function create(
        AssetCode $assetId,
        AssetPrototype $assetPrototype,
        CharacterId $creatorCharacterId
    ): Asset
    {
        return new Asset(
            $assetId,
            $assetPrototype->getName()
            // $assetPrototype->getDescription(),
            // $assetPrototype->getImageFilePath(),
            // $assetPrototype->getType(),
            // $assetPrototype->getEffects(),
            // $assetPrototype->getPrice(),
            // $assetPrototype->getId(),
            // $creatorCharacterId
        );
    }
}
