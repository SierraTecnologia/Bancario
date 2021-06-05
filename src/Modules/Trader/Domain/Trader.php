<?php


namespace Bancario\Modules\Trader\Domain;

use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Models\Trader\Trader as TraderModel;
use Bancario\Models\Trader\TraderHistory;
use Bancario\Modules\OpenBanking\Domain\TraderAsset;
use Bancario\Modules\Trader\Application\Services\TraderService;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Bancario\Modules\OpenBanking\Domain\AssetEffect;
use Bancario\Modules\OpenBanking\Domain\Money;
use Bancario\Modules\Image\Domain\ImageId;
use Muleta\Traits\ThrowsDice;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\Trader\Infrastructure\Repositories\TraderRepository;
use Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories\TraderReconstitutionFactory;

class Trader
{
    use ThrowsDice;

    /**
     * @var TraderId
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $assets;

    /**
     * @var bool
     */
    private $isBacktest;
    // /**
    //  * @var Carbon
    //  */
    // private $isBacktest;
    /**
     * @var string
     */
    private $exchangeCode;
    // /**
    //  * @var string
    //  */
    // private $locationId;
    /**
     * @var Carbon
     */
    private $processingTime;
    // /**
    //  * @var Reputation
    //  */
    // private $reputation;
    // /**
    //  * @var Attributes
    //  */
    // private $attributes;
    // /**
    //  * @var HitPoints
    //  */
    // private $hitPoints;
    // /**
    //  * @var Statistics
    //  */
    // private $statistics;
    /**
     * @var Inventory
     */
    private $inventory;
    // /**
    //  * @var int|null
    //  */
    // private $userId;
    // /**
    //  * @var ImageId
    //  */
    // private $profilePictureId;


    /**
     * @var Collection
     */
    private $histories;

    /**
     * @var Collection
     */
    private $orders;

    public function __construct(
        TraderId $id,
        string $name,
        string $exchangeCode,
        Collection $assets,
        bool $isBacktest,
        // int $levelId,
        // string $locationId,
        Carbon $processingTime,
        // Gender $gender,
        // int $xp,
        // Reputation $reputation,
        // Attributes $attributes,
        // HitPoints $hitPoints,
        // Statistics $statistics,
        // Inventory $inventory
        // int $userId = null,
        // ImageId $profilePictureId = null
        Collection $histories,
        Collection $orders
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->exchangeCode = $exchangeCode;
        $this->assets = $assets;
        $this->isBacktest = $isBacktest;
    //     $this->gender = $gender;
    //     $this->levelId = $levelId;
    //     $this->locationId = $locationId;
        $this->processingTime = $processingTime;
    //     $this->reputation = $reputation;
    //     $this->attributes = $attributes;
    //     $this->hitPoints = $hitPoints;
    //     $this->statistics = $statistics;
        // $this->inventory = $inventory;
    //     $this->userId = $userId;
    //     $this->profilePictureId = $profilePictureId;
        $this->histories = $histories;
        $this->orders = $orders;
    }

    public function getId(): TraderId
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }
    public function getExchangeCode(): string
    {
        return $this->exchangeCode;
    }
    public function getIsBacktest(): bool
    {
        return $this->isBacktest;
    }

    public function getProcessingTime(): Carbon
    {
        return $this->processingTime;
    }

    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function findAsset(AssetCode $assetCode):? TraderAsset
    {
        return $this->assets->first(static function (TraderAsset $asset) use ($assetCode) {
            return $asset->getId()->equals($assetCode);
        });
    }
    /**
     * MISSAO 1
     */


    public function depositAsset(AssetCode $assetCode, float $value)
    {
        $traderModel = TraderModel::find($this->id->toString());
        if (!$asset = $this->findAsset($assetCode)) {
            $traderModel->assets()->attach($assetCode->toString(), [
                'value' => $value
            ]);
            
            $traderReconstitutionFactory = app(TraderReconstitutionFactory::class);
            $this->assets = $traderReconstitutionFactory->reconstituteAssets($traderModel);
        } else {
            // Update Quantidade no Banco
            $asset->deposit($value);
            $traderModel->assets()->updateExistingPivot($assetCode->toString(), ['value' => $asset->getValue()]);
        }

        $traderModel->histories()->create(
            [
                'type' => TraderHistory::DEPOSIT,
                'asset_code' => $assetCode->toString(),
                'value' => $value,
                'processing_time' => now()
            ]
        );
        $this->updateProcessingTime();
    }

    public function withdrawAsset(AssetCode $assetCode, float $value)
    {
        if (!$asset = $this->findAsset($assetCode)) {
            throw new Exception('Você não possui esse ativo');
        }
        if ($asset->getValue()<$value) {
            throw new Exception('Você não possui saldo nesse ativo');
        }

        $asset->withdraw($value);

        // Update Quantidade no Banco
        $traderModel = TraderModel::find($this->id->toString());
        $traderModel->assets()->updateExistingPivot($assetCode->toString(), ['value' => $asset->getValue()]);
        $traderModel->histories()->create(
            [
                'type' => TraderHistory::WITHDRAW,
                'asset_code' => $assetCode->toString(),
                'value' => -1 * $value,
                'processing_time' => now()
            ]
        );
        
        $this->updateProcessingTime();
    }

    public function traddingAsset(
        AssetCode $sellerAssetCode,
        AssetCode $buyerAssetCode,
        float $value,
        float $pricePayed,
        float $taxaInPercent = 0 // Em Porcentagem
    )
    {
        /**
         * Primeiro Vende o Ativo
         */
        if (!$sellerAsset = $this->findAsset($sellerAssetCode)) {
            throw new Exception('Você não possui esse ativo');
        }
        if ($sellerAsset->getValue()<$value) {
            throw new Exception('Você não possui saldo nesse ativo');
        }
        $sellerAsset->withdraw($value);

        // Update Quantidade no Banco
        $traderModel = TraderModel::find($this->id->toString());
        $traderModel->assets()->updateExistingPivot($sellerAssetCode->toString(), ['value' => $sellerAsset->getValue()]);
        $traderModel->histories()->create(
            [
                'type' => TraderHistory::SELLING,
                'asset_code' => $sellerAssetCode->toString(),
                'value' => -1 * $value,
                'processing_time' => now()
            ]
        );


        /**
         * Calculos
         */
        $gastoComTaxa = $value*($taxaInPercent/100);
        $valueDescontadoATaxa = $value*(1-$taxaInPercent/100);
        $valueToBuy = $valueDescontadoATaxa*$pricePayed;


        /**
         * Depois Compra
         */
        if (!$buyerAsset = $this->findAsset($buyerAssetCode)) {
            $traderModel->assets()->attach($buyerAsset->toString(), [
                'value' => $valueToBuy
            ]);
            
            $traderReconstitutionFactory = app(TraderReconstitutionFactory::class);
            $this->assets = $traderReconstitutionFactory->reconstituteAssets($traderModel);
        } else {
            // Update Quantidade no Banco
            $buyerAsset->deposit($valueToBuy);
            $traderModel->assets()->updateExistingPivot($buyerAssetCode->toString(), ['value' => $buyerAsset->getValue()]);
        }
        $traderModel->histories()->create(
            [
                'type' => TraderHistory::BUYING,
                'asset_code' => $buyerAssetCode->toString(),
                'value' => $valueToBuy,
                'processing_time' => now()
            ]
        );
        
        $traderModel->orders()->create(
            [
                'asset_seller_code' => $sellerAssetCode->toString(),
                'asset_buyer_code' => $buyerAssetCode->toString(),
                'value' => $value,
                'price' => $pricePayed,
                'taxa' => $gastoComTaxa,
                'processing_time' => now()
            ]
        );
        $this->updateProcessingTime();
    }




    public function getHistories(): Collection
    {
        return $this->histories;
    }

    /**
     * 
     */
    protected function updateProcessingTime()
    {
        $this->processingTime = Carbon::now();
        $this->persist();
    }

    public function persist()
    {
        $service = app(TraderRepository::class);
        $service->update($this);
    }
}
