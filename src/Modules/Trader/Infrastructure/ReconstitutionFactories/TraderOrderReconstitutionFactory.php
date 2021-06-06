<?php


namespace Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\TraderOrder as TraderOrderModel;
use Bancario\Modules\Trader\Domain\TraderOrder;
use Bancario\Modules\OpenBanking\Domain\AssetCode;


class TraderOrderReconstitutionFactory
{

    public function reconstitute(TraderOrderModel $model): TraderOrder
    {
        return new TraderOrder(
            AssetCode::fromString($model->asset_seller_code),
            AssetCode::fromString($model->asset_buyer_code),
            $model->value,
            $model->price,
            $model->taxa,
            $model->processing_time,
            $model->vars?$model->vars:[]
        );
    }
}
