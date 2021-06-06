<?php

namespace Bancario\Modules\OpenBanking\Domain;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\Generic\Domain\Container\ContainerIsFullException;
use Bancario\Modules\Generic\Domain\Container\AssetNotInContainer;
use Bancario\Modules\Generic\Domain\Container\NotEnoughSpaceInContainerException;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Inventory
{
    public const NUMBER_OF_SLOTS = 24;

    /**
     * @var InventoryId
     */
    private $id;

    /**
     * @var CharacterId
     */
    private $characterId;

    /**
     * @var Collection
     */
    private $assets;

    /**
     * @var Money
     */
    private $money;

    public function __construct(InventoryId $id, CharacterId $characterId, Collection $assets, Money $money)
    {
        if ($assets->count() > self::NUMBER_OF_SLOTS) {
            throw new NotEnoughSpaceInContainerException(
                "Not enough space in the Inventory for {$assets->count()} new assets"
            );
        }

        $assets->each(static function ($asset) {
           if (!($asset instanceof InventoryAsset)) {
               throw new InvalidArgumentException('Trying to populate inventory with non inventory asset');
           }
        });

        $this->id = $id;
        $this->characterId = $characterId;
        $this->assets = $assets;
        $this->money = $money;
    }

    public function getId(): InventoryId
    {
        return $this->id;
    }

    public function add(Asset $asset): void
    {
        $asset = new InventoryAsset($asset, AssetStatus::inBackpack());

        $slot = $this->findFreeSlot();

        $this->assets->put($slot, $asset);
    }

    public function getEquippedAssetsEffect(string $assetEffectType): int
    {
        return (int)$this->getEquippedAssets()->reduce(static function ($carry, InventoryAsset $asset) use ($assetEffectType) {

            $assetEffect = $asset->getAssetEffect($assetEffectType);

            return $carry + $assetEffect;
        });
    }

    public function unEquipAsset(AssetCode $assetId): void
    {
        $equippedAsset = $this->findEquippedAsset($assetId);

        if ($equippedAsset)
        {
            $equippedAsset->unEquip();
        }
    }

    public function equip(AssetCode $assetId): void
    {
        $asset = $this->findAsset($assetId);
        if (!$asset) {
            throw new AssetNotInContainer('Cannot equip asset that is not in the inventory');
        }

        if ($equippedAsset = $this->findEquippedAssetOfType($asset->getType())) {
            $equippedAsset->unEquip();
        }

        $asset->equip();
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function takeOut(AssetCode $assetId): Asset
    {
        $slot = $this->assets->search(static function (InventoryAsset $asset) use ($assetId) {
            return $asset->getId()->equals($assetId);
        });

        if ($slot === false) {
            throw new AssetNotInContainer('Cannot take out asset from empty slot');
        }

        /** @var InventoryAsset $asset */
        $asset = $this->assets->get($slot);

        $this->assets->forget($slot);

        return $asset->toBaseAsset();
    }

    public function putMoneyIn(Money $money): void
    {
        $this->money = $this->money->combine($money);
    }

    public function takeMoneyOut(Money $money): Money
    {
        $this->money = $this->money->remove($money);

        return $money;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function findAsset(AssetCode $assetId):? InventoryAsset
    {
        return $this->assets->first(static function (InventoryAsset $asset) use ($assetId) {
            return $asset->getId()->equals($assetId);
        });
    }

    private function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!$this->assets->has($slot)) {
                return $slot;
            }
        }

        throw new ContainerIsFullException('Cannot add to full inventory');
    }

    private function findEquippedAsset(AssetCode $assetId):? InventoryAsset
    {
        return $this->assets->first(static function (InventoryAsset $asset) use ($assetId) {
            return $asset->getId()->equals($assetId) && $asset->isEquipped();
        });
    }

    private function findEquippedAssetOfType(AssetType $type):? InventoryAsset
    {
        return $this->assets->first(static function (InventoryAsset $asset) use ($type) {
            return $asset->isOfType($type) && $asset->isEquipped();
        });
    }

    private function getEquippedAssets(): Collection
    {
        return $this->assets->filter(static function (InventoryAsset $asset) {
            return $asset->isEquipped();
        });
    }
}
