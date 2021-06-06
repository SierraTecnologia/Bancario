<?php


namespace Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories;

use Bancario\Models\Trader\Asset as AssetModel;
use Bancario\Models\Trader\Inventory as InventoryModel;
use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\OpenBanking\Domain\InventoryId;
use Bancario\Modules\OpenBanking\Domain\Money;

class InventoryReconstitutionFactory
{
    /**
     * @var InventoryAssetReconstitutionFactory
     */
    private $inventoryAssetReconstitutionFactory;

    public function __construct(InventoryAssetReconstitutionFactory $inventoryAssetReconstitutionFactory)
    {
        $this->inventoryAssetReconstitutionFactory = $inventoryAssetReconstitutionFactory;
    }

    public function reconstitute(InventoryModel $inventoryModel): Inventory
    {
        $assets = $inventoryModel->assets->mapWithKeys(function (AssetModel $assetModel) {

            $key = $assetModel->getInventorySlotNumber();
            $inventoryAsset = $this->inventoryAssetReconstitutionFactory->reconstitute($assetModel);

            return [$key => $inventoryAsset];
        });

        return new Inventory(
            InventoryId::fromString($inventoryModel->getId()),
            CharacterId::fromString($inventoryModel->getCharacterId()),
            $assets,
            new Money($inventoryModel->getMoney())
        );
    }
}
