<?php

namespace Bancario\Modules\OpenBanking\Domain;


use Illuminate\Support\Collection;

class AssetPrototype
{
    /**
     * @var AssetPrototypeId
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
     * @var string
     */
    private $imageFilePath;
    /**
     * @var AssetType
     */
    private $type;
    /**
     * @var Collection
     */
    private $effects;
    /**
     * @var AssetPrice
     */
    private $price;

    public function __construct(
        AssetPrototypeId $id,
        string $name,
        string $description,
        string $imageFilePath,
        AssetType $type,
        Collection $effects,
        AssetPrice $price
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->effects = $effects;
        $this->price = $price;
    }

    public function getId(): AssetPrototypeId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageFilePath(): string
    {
        return $this->imageFilePath;
    }

    public function getType(): AssetType
    {
        return $this->type;
    }

    public function getEffects(): Collection
    {
        return $this->effects;
    }

    public function getPrice(): AssetPrice
    {
        return $this->price;
    }
}
