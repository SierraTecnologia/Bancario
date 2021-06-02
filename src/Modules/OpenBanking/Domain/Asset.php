<?php

namespace Bancario\Modules\OpenBanking\Domain;


use Bancario\Modules\Character\Domain\CharacterId;
use Illuminate\Support\Collection;

class Asset
{
    /**
     * @var AssetCode
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var AssetType
     */
    private $type;
    /**
     * @var Collection
     */
    private $effects;
    /**
     * @var AssetPrototypeId
     */
    private $prototypeId;
    /**
     * @var CharacterId
     */
    private $creatorCharacterId;
    /**
     * @var string
     */
    private $imageFilePath;
    /**
     * @var AssetPrice
     */
    private $price;

    public function __construct(
        AssetCode $id,
        string $name
        // string $description,
        // string $imageFilePath,
        // AssetType $type,
        // Collection $effects,
        // AssetPrice $price,
        // AssetPrototypeId $prototypeId,
        // CharacterId $creatorCharacterId
    )
    {
        $this->id = $id;
        $this->name = $name;
        // $this->description = $description;
        // $this->imageFilePath = $imageFilePath;
        // $this->type = $type;
        // $this->effects = $effects;
        // $this->price = $price;
        // $this->prototypeId = $prototypeId;
        // $this->creatorCharacterId = $creatorCharacterId;
    }

    public function getId(): AssetCode
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // public function getDescription(): string
    // {
    //     return $this->description;
    // }

    // public function getImageFilePath(): string
    // {
    //     return $this->imageFilePath;
    // }

    // public function getType(): AssetType
    // {
    //     return $this->type;
    // }

    // public function getEffects(): Collection
    // {
    //     return $this->effects;
    // }

    // public function getPrototypeId(): AssetPrototypeId
    // {
    //     return $this->prototypeId;
    // }

    // public function getCreatorCharacterId(): CharacterId
    // {
    //     return $this->creatorCharacterId;
    // }

    // public function getAssetEffect(string $assetEffectType): int
    // {
    //     return (int)$this->getEffectsOfType($assetEffectType)
    //         ->reduce(static function ($carry, AssetEffect $assetEffect) {
    //             return $carry + $assetEffect->getQuantity();
    //         });
    // }

    // private function getEffectsOfType(string $assetEffectType): Collection
    // {
    //     return $this->effects->filter(static function (AssetEffect $effect) use ($assetEffectType) {
    //         return $effect->getType() === $assetEffectType;
    //     });
    // }

    // public function equals(Asset $otherAsset): bool
    // {
    //     return $this->getId()->equals($otherAsset->getId());
    // }

    // public function isOfType(AssetType $type): bool
    // {
    //     return $this->getType()->equals($type);
    // }

    // public function getPrice(): AssetPrice
    // {
    //     return $this->price;
    // }

    // public function changePrice(AssetPrice $price): void
    // {
    //     $this->price = $price;
    // }
}
