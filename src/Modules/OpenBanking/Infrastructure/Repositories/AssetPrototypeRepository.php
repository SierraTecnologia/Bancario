<?php

namespace Bancario\Modules\OpenBanking\Infrastructure\Repositories;

use Bancario\Models\Trader\AssetPrototype as AssetPrototypeModel;
use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;
use Bancario\Modules\OpenBanking\Application\Contracts\AssetPrototypeRepositoryInterface;
use Bancario\Modules\OpenBanking\Domain\AssetPrototype;
use Bancario\Modules\OpenBanking\Infrastructure\ReconstitutionFactories\AssetPrototypeReconstitutionFactory;
use Muleta\Traits\GeneratesUuid;
use Exception;

class AssetPrototypeRepository implements AssetPrototypeRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var AssetPrototypeReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(AssetPrototypeReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return AssetPrototypeId
     *
     * @throws Exception
     */
    public function nextIdentity(): AssetPrototypeId
    {
        return AssetPrototypeId::fromString($this->generateUuid());
    }

    public function getOne(AssetPrototypeId $assetPrototypeId): AssetPrototype
    {
        /** @var AssetPrototypeModel $model */
        $model = AssetPrototypeModel::query()->findOrFail($assetPrototypeId->toString());

        return $this->reconstitutionFactory->reconstitute($model);
    }
}
