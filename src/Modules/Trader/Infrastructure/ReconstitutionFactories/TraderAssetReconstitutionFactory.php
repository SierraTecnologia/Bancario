<?php


namespace Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\Asset as AssetModel;
use Bancario\Modules\OpenBanking\Domain\TraderAsset;


class TraderAssetReconstitutionFactory
{
    /**
     * @var AssetReconstitutionFactory
     */
    private $assetReconstitutionFactory;

    public function __construct(AssetReconstitutionFactory $assetReconstitutionFactory)
    {
        $this->assetReconstitutionFactory = $assetReconstitutionFactory;
    }

    public function reconstitute(AssetModel $model): TraderAsset
    {
        return new TraderAsset(
            $this->assetReconstitutionFactory->reconstitute($model),
            $model->pivot->value
        );
    }
}
