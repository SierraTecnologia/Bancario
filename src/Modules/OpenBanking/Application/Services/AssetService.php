<?php

namespace Bancario\Modules\OpenBanking\Application\Services;

use Bancario\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use Bancario\Modules\OpenBanking\Application\Commands\CreateAssetCommand;
use Bancario\Modules\OpenBanking\Application\Contracts\AssetPrototypeRepositoryInterface;
use Bancario\Modules\OpenBanking\Application\Contracts\AssetRepositoryInterface;
use Bancario\Modules\OpenBanking\Domain\Asset;
use Bancario\Modules\OpenBanking\Application\Factories\AssetFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class AssetService
{
    /**
     * @var AssetRepositoryInterface
     */
    private $assetRepository;
    /**
     * @var AssetFactory
     */
    private $assetFactory;
    /**
     * @var AssetPrototypeRepositoryInterface
     */
    private $assetPrototypeRepository;
    /**
     * @var \Bancario\Modules\Character\Application\Contracts\CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        AssetRepositoryInterface $assetRepository,
        AssetPrototypeRepositoryInterface $assetPrototypeRepository,
        AssetFactory $assetFactory
    )
    {
        $this->characterRepository = $characterRepository;
        $this->assetRepository = $assetRepository;
        $this->assetPrototypeRepository = $assetPrototypeRepository;
        $this->assetFactory = $assetFactory;
    }

    public function create(CreateAssetCommand $command): void
    {
        DB::transaction(function () use ($command) {
            $assetPrototype = $this->assetPrototypeRepository->getOne($command->getPrototypeId());
            $character = $this->characterRepository->getOne($command->getCreatorCharacterId());
            $assetId = $this->assetRepository->nextIdentity();

            $asset = $this->assetFactory->create($assetId, $assetPrototype, $character->getId());

            $character->addAssetToInventory($asset);

            $this->assetRepository->add($asset);
            $this->characterRepository->update($character);
        });
    }
}
