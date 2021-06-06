<?php


namespace Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\AssetPrototype as AssetPrototypeModel;
use Bancario\Modules\OpenBanking\Domain\AssetPrice;
use Bancario\Modules\OpenBanking\Domain\AssetPrototype;
use Bancario\Modules\OpenBanking\Domain\AssetEffect;
use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;
use Bancario\Modules\OpenBanking\Domain\AssetType;
use Illuminate\Support\Collection;


class AssetPrototypeReconstitutionFactory
{
    public function reconstitute(AssetPrototypeModel $model): AssetPrototype
    {
        $effects = Collection::make($model->getEffects())->map(static function (array $effect) {
                return AssetEffect::ofType(
                    $effect['quantity'],
                    $effect['type']);
            });

        $assetPrototype = new AssetPrototype(
            AssetPrototypeId::fromString($model->getId()),
            $model->getName(),
            $model->getDescription(),
            $model->getImageFilePath(),
            AssetType::ofType($model->getType()),
            $effects,
            AssetPrice::ofAmount($model->getPrice())
        );

        return $assetPrototype;
    }
}
