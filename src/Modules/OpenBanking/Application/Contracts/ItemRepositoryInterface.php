<?php

namespace Bancario\Modules\OpenBanking\Application\Contracts;

use Bancario\Modules\OpenBanking\Domain\AssetCode;
use Bancario\Modules\OpenBanking\Domain\Asset;

interface AssetRepositoryInterface
{
    public function nextIdentity(): AssetCode;

    public function add(Asset $asset): void;

    public function getOne(AssetCode $assetId): Asset;

    public function update(Asset $asset): void;
}
