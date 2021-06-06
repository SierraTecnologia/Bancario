<?php


namespace Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\TraderHistory as TraderHistoryModel;
use Bancario\Modules\Trader\Domain\TraderHistory;
use Bancario\Modules\OpenBanking\Domain\AssetCode;


class TraderHistoryReconstitutionFactory
{

    public function reconstitute(TraderHistoryModel $model): TraderHistory
    {
        return new TraderHistory(
            AssetCode::fromString($model->asset_code),
            $model->type,
            $model->value,
            $model->processing_time
        );
    }
}
