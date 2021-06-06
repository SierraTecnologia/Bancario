<?php declare(strict_types=1);


namespace Bancario\Modules\OpenBanking\Application\Services;

use Bancario\Modules\OpenBanking\Application\Commands\CreateInventoryCommand;
use Bancario\Modules\OpenBanking\Application\Commands\EquipAssetCommand;
use Bancario\Modules\OpenBanking\Application\Contracts\InventoryRepositoryInterface;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\OpenBanking\Domain\Money;
use Illuminate\Support\Collection;

class InventoryService
{
    /**
     * @var InventoryRepositoryInterface
     */
    private $inventoryRepository;

    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function create(CreateInventoryCommand $command):Inventory
    {
        $id = $this->inventoryRepository->nextIdentity();

        $inventory = new Inventory($id, $command->getCharacterId(), Collection::make(), new Money(0));

        $this->inventoryRepository->add($inventory);

        return $inventory;
    }

    public function equipAsset(EquipAssetCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getOwnerCharacterId());

        $inventory->equip($command->getAssetCode());

        $this->inventoryRepository->update($inventory);
    }

    public function unEquipAsset(EquipAssetCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getOwnerCharacterId());

        $inventory->unEquipAsset($command->getAssetCode());

        $this->inventoryRepository->update($inventory);
    }
}
