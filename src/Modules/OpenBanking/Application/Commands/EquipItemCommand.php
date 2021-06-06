<?php

namespace Bancario\Modules\OpenBanking\Application\Commands;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetCode;

class EquipAssetCommand
{
    /**
     * @var AssetCode
     */
    private $assetId;
    /**
     * @var CharacterId
     */
    private $ownerCharacterId;

    public function __construct(AssetCode $assetId, CharacterId $ownerCharacterId)
    {
        $this->assetId = $assetId;
        $this->ownerCharacterId = $ownerCharacterId;
    }

    public function getAssetCode(): AssetCode
    {
        return $this->assetId;
    }

    public function getOwnerCharacterId(): CharacterId
    {
        return $this->ownerCharacterId;
    }
}
