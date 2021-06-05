<?php

namespace Bancario\Modules\Trader\Domain;

use Muleta\Modules\Generic\Domain\Container\InvalidMoneyValue;
use Muleta\Modules\Generic\Domain\Container\NotEnoughMoneyToRemove;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Carbon\Carbon;

class TraderOrder
{
    /**
     * @var AssetCode
     */
    private $assetSellerCode;
    /**
     * @var AssetCode
     */
    private $assetBuyerCode;

    /**
     * @var float
     */
    private $value;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $taxa;
    
    /**
     * @var Carbon
     */
    private $processingTime;
    
    /**
     * @var array
     */
    private $vars;

    public function __construct(
        AssetCode $assetSellerCode,
        AssetCode $assetBuyerCode,
        float $value,
        float $price,
        float $taxa,
        Carbon $processingTime,
        array $vars = []
    )
    {
        $this->assetSellerCode = $assetSellerCode;
        $this->assetBuyerCode = $assetBuyerCode;
        $this->value = $value;
        $this->price = $price;
        $this->taxa = $taxa;
        $this->processingTime = $processingTime;
        $this->vars = $vars;
    }

    public function getAssetSellerCode(): AssetCode
    {
        return $this->assetSellerCode;
    }

    public function getAssetBuyerCode(): AssetCode
    {
        return $this->assetBuyerCode;
    }
    
    public function getValue(): float
    {
        return $this->value;
    }
    
    public function getPrice(): float
    {
        return $this->price;
    }
    
    public function getTaxa(): float
    {
        return $this->taxa;
    }

    public function getProcessingTime(): Carbon
    {
        return $this->processingTime;
    }
    
    public function getVars(): array
    {
        return $this->vars;
    }
}
