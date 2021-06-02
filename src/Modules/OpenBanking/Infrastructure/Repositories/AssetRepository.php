<?php

namespace Bancario\Modules\OpenBanking\Infrastructure\Repositories;

use Bancario\Models\Trader\Asset as AssetModel;
use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Application\Contracts\AssetRepositoryInterface;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Bancario\Modules\OpenBanking\Domain\AssetEffect;
use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\AssetReconstitutionFactory;
use Muleta\Traits\GeneratesUuid;
use Exception;

class AssetRepository implements AssetRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var AssetReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(AssetReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return AssetCode
     *
     * @throws Exception
     */
    public function nextIdentity(): AssetCode
    {
        return AssetCode::fromString($this->generateUuid());
    }

    public function add(Asset $asset): void
    {
        $effects = $asset->getEffects()->map(static function (AssetEffect $effect) {
            return [
                'quantity' => $effect->getQuantity(),
                'type' => $effect->getType(),
            ];
        })->toJson();

        AssetModel::query()->create([
            'id' => $asset->getId()->toString(),

            'prototype_id' => $asset->getPrototypeId()->toString(),
            'creator_character_id' => $asset->getCreatorCharacterId()->toString(),

            'name' => $asset->getName(),
            'description' => $asset->getDescription(),

            'effects' => $effects,

            'price' => $asset->getPrice()->getAmount(),

            'image_file_path' => $asset->getImageFilePath(),

            'type' => $asset->getType()->toString(),
        ]);
    }

    public function getOne(AssetCode $assetId): Asset
    {
        /** @var AssetModel $model */
        $model = AssetModel::query()->findOrFail($assetId->toString());

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function update(Asset $asset): void
    {
        $effects = $asset->getEffects()->map(static function (AssetEffect $effect) {
            return [
                'quantity' => $effect->getQuantity(),
                'type' => $effect->getType(),
            ];
        })->toJson();

        AssetModel::query()->where('id', $asset->getId()->toString())->update([
            'prototype_id' => $asset->getPrototypeId()->toString(),
            'creator_character_id' => $asset->getCreatorCharacterId()->toString(),

            'name' => $asset->getName(),
            'description' => $asset->getDescription(),

            'effects' => $effects,

            'price' => $asset->getPrice()->getAmount(),

            'image_file_path' => $asset->getImageFilePath(),

            'type' => $asset->getType()->toString(),
        ]);
    }
}
