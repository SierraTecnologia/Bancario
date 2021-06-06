<?php

namespace Bancario\Modules\OpenBanking\Infrastructure\Repositories;

use Bancario\Models\Trader\Inventory as InventoryModel;
use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Application\Contracts\InventoryRepositoryInterface;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\OpenBanking\Domain\InventoryId;
use Bancario\Modules\OpenBanking\Domain\InventoryAsset;
use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\InventoryReconstitutionFactory;
use Muleta\Traits\GeneratesUuid;
use Exception;

class InventoryRepository implements InventoryRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var InventoryReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(InventoryReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return InventoryId
     *
     * @throws Exception
     */
    public function nextIdentity(): InventoryId
    {
        return InventoryId::fromString($this->generateUuid());
    }

    public function add(Inventory $inventory): void
    {
        InventoryModel::query()->create([
            'id' => $inventory->getId()->toString(),
            'character_id' => $inventory->getCharacterId()->toString(),
            'money' => $inventory->getMoney()->getValue(),
        ]);
    }

    public function forCharacter(CharacterId $characterId): Inventory
    {
        /** @var InventoryModel $model */
        $model = InventoryModel::query()->where('character_id', $characterId->toString())->firstOrFail();

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function update(Inventory $inventory): void
    {
        /** @var InventoryModel $inventoryModel */
        $inventoryModel = InventoryModel::query()->findOrFail($inventory->getId()->toString());

        $inventoryAssets = $inventory->getAssets()->mapWithKeys(static function (InventoryAsset $asset, int $slot) {
            $assetId = $asset->getId()->toString();

            return [
                $assetId => [
                    'asset_id' => $assetId,
                    'status' => $asset->getStatus()->toString(),
                    'inventory_slot_number' => $slot,
                ],
            ];
        });

         $inventoryModel->assets()->sync($inventoryAssets->all());

         $inventoryModel->update([
             'money' => $inventory->getMoney()->getValue(),
         ]);
    }
}
