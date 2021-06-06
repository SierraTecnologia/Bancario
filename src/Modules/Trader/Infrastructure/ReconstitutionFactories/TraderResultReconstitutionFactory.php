<?php


namespace Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories;

use Bancario\Modules\Trader\Domain\TraderId;
use Bancario\Models\Trader\Asset as AssetModel;
use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\InventoryReconstitutionFactory;
use Bancario\Modules\Trader\Domain\Attributes;
use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Modules\Trader\Domain\Gender;
use Bancario\Modules\Trader\Domain\Statistics;
use Bancario\Modules\Trader\Domain\HitPoints;
use Bancario\Modules\Trader\Domain\Reputation;
use Bancario\Models\Trader\Trader as TraderModel;
use Bancario\Modules\Image\Domain\ImageId;
use Bancario\Models\Trader\TraderHistory as TraderHistoryModel;
use Bancario\Modules\Trader\Domain\TraderHistory;
use Bancario\Models\Trader\TraderOrder as TraderOrderModel;
use Bancario\Modules\Trader\Domain\TraderOrder;

use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\TraderAssetReconstitutionFactory;

class TraderResultReconstitutionFactory
{
    /**
     * @var TraderAssetReconstitutionFactory
     */
    private $traderAssetReconstitutionFactory;

    /**
     * @var TraderHistoryReconstitutionFactory
     */
    private $traderHistoryReconstitutionFactory;

    /**
     * @var TraderOrderReconstitutionFactory
     */
    private $traderOrderReconstitutionFactory;

    public function __construct(
        TraderAssetReconstitutionFactory $traderAssetReconstitutionFactory,
        TraderHistoryReconstitutionFactory $traderHistoryReconstitutionFactory,
        TraderOrderReconstitutionFactory $traderOrderReconstitutionFactory
        )
    {
        $this->traderAssetReconstitutionFactory = $traderAssetReconstitutionFactory;
        $this->traderHistoryReconstitutionFactory = $traderHistoryReconstitutionFactory;
        $this->traderOrderReconstitutionFactory = $traderOrderReconstitutionFactory;
    }

    public function reconstitute(TraderModel $traderModel): Trader
    {
        
        return new Trader(
            TraderId::fromString($traderModel->getId()),
            $traderModel->name,
            $traderModel->exchange_code,
            // CharacterId::fromString($inventoryModel->getCharacterId()),
            $this->reconstituteAssets($traderModel),
            $traderModel->is_backtest,
            $traderModel->processing_time,
            $this->reconstituteHistories($traderModel),
            $this->reconstituteOrders($traderModel)
            // new Money($inventoryModel->getMoney())
        );
        // $inventory = $this->inventoryReconstitutionFactory->reconstitute($traderModel->inventory);

        // $profilePictureId = $traderModel->getProfilePictureId();

        // $trader = new Trader(
        //     TraderId::fromString($traderModel->getId()),
        //     $traderModel->getExchangeCode(),
        //     $traderModel->getLevelNumber(),
        //     $traderModel->getLocationId(),
        //     $traderModel->getName(),
        //     new Gender($traderModel->getGender()),
        //     $traderModel->getXp(),
        //     new Reputation(0),
        //     new Attributes([
        //         'strength' => $traderModel->getStrength(),
        //         'agility' => $traderModel->getAgility(),
        //         'constitution' => $traderModel->getConstitution(),
        //         'intelligence' => $traderModel->getIntelligence(),
        //         'charisma' => $traderModel->getCharisma(),
        //         'unassigned' => $traderModel->getAvailableAttributePoints(),
        //     ]),
        //     new HitPoints(
        //         $traderModel->getHitPoints(),
        //         $traderModel->getTotalHitPoints()
        //     ),
        //     new Statistics([
        //         'battlesLost' => $traderModel->getBattlesLost(),
        //         'battlesWon' => $traderModel->getBattlesWon(),
        //     ]),
        //     $inventory,
        //     $traderModel->getUserId(),
        //     $profilePictureId ? ImageId::fromString($profilePictureId) : null
        // );

        // return $trader;
    }

    public function reconstituteAssets(TraderModel $traderModel)
    {
        return $traderModel->assets->mapWithKeys(function (AssetModel $assetModel) {

            $key = $assetModel->getId();
            $traderAsset = $this->traderAssetReconstitutionFactory->reconstitute($assetModel);

            return [$key => $traderAsset];
        });
    }

    public function reconstituteHistories(TraderModel $traderModel)
    {
        return $traderModel->histories->mapWithKeys(function (TraderHistoryModel $traderHistoryModel) {

            $key = $traderHistoryModel->getId();
            $traderHistory = $this->traderHistoryReconstitutionFactory->reconstitute($traderHistoryModel);

            return [$key => $traderHistory];
        });
    }
    public function reconstituteOrders(TraderModel $traderModel)
    {
        return $traderModel->orders->mapWithKeys(function (TraderOrderModel $traderOrderModel) {

            $key = $traderOrderModel->getId();
            $traderOrder = $this->traderOrderReconstitutionFactory->reconstitute($traderOrderModel);

            return [$key => $traderOrder];
        });
    }
}
