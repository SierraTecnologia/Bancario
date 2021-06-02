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

use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\TraderAssetReconstitutionFactory;

class TraderReconstitutionFactory
{
    /**
     * @var TraderAssetReconstitutionFactory
     */
    private $traderAssetReconstitutionFactory;

    public function __construct(TraderAssetReconstitutionFactory $traderAssetReconstitutionFactory)
    {
        $this->traderAssetReconstitutionFactory = $traderAssetReconstitutionFactory;
    }

    public function reconstituteAssets(TraderModel $traderModel)
    {
        return $traderModel->assets->mapWithKeys(function (AssetModel $assetModel) {

            $key = $assetModel->getId();
            $traderAsset = $this->traderAssetReconstitutionFactory->reconstitute($assetModel);

            return [$key => $traderAsset];
        });
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
}
