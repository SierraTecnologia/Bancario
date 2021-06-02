<?php


namespace Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\Asset as AssetModel;
use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Bancario\Modules\OpenBanking\Domain\AssetEffect;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Domain\AssetPrice;
use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;
use Bancario\Modules\OpenBanking\Domain\AssetType;
use Illuminate\Support\Collection;


class AssetReconstitutionFactory
{
    public function reconstitute(AssetModel $model): Asset
    {
        // $effects = Collection::make($model->getEffects())->map(static function (array $effect) {
        //     return AssetEffect::ofType(
        //         $effect['quantity'],
        //         $effect['type']
        //     );
        // });

        $asset = new Asset(
            AssetCode::fromString($model->getId()),
            $model->getName(),
            // $model->getDescription(),
            // $model->getImageFilePath(),
            // AssetType::ofType($model->getType()),
            // $effects,
            // AssetPrice::ofAmount($model->getPrice()),
            // AssetPrototypeId::fromString($model->getPrototypeId()),
            // CharacterId::fromString($model->getCreatorCharacterId())
        );

        return $asset;
    }
}
