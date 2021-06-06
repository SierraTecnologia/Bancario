<?php

namespace Bancario\Modules\Trader\Domain;

use Muleta\Modules\Generic\Domain\Container\InvalidMoneyValue;
use Muleta\Modules\Generic\Domain\Container\NotEnoughMoneyToRemove;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Carbon\Carbon;

class TraderHistory
{
    /**
     * @var AssetCode
     */
    private $assetCode;
    /**
     * @var string
     */
    private $type;
    /**
     * @var float
     */
    private $value;
    /**
     * @var Carbon
     */
    private $processingTime;

    public function __construct(AssetCode $assetCode, string $type, float $value, Carbon $processingTime)
    {
        $this->assetCode = $assetCode;
        $this->type = $type;
        $this->value = $value;
        $this->processingTime = $processingTime;
    }

    public function getAssetCode(): AssetCode
    {
        return $this->assetCode;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getProcessingTime(): Carbon
    {
        return $this->processingTime;
    }
}
