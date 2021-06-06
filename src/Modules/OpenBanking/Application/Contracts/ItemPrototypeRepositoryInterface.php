<?php

namespace Bancario\Modules\OpenBanking\Application\Contracts;

use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;
use Bancario\Modules\OpenBanking\Domain\AssetPrototype;

interface AssetPrototypeRepositoryInterface
{
    public function nextIdentity(): AssetPrototypeId;

    public function getOne(AssetPrototypeId $assetPrototypeId): AssetPrototype;
}
