<?php

namespace Bancario\Modules\OpenBanking\Application\Commands;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetCode;

class AddAssetToInventoryCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;
    /**
     * @var int
     */
    private $slot;
    /**
     * @var AssetCode
     */
    private $assetId;

    public function __construct(CharacterId $characterId, int $slot, AssetCode $assetId)
    {
        $this->characterId = $characterId;
        $this->slot = $slot;
        $this->assetId = $assetId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getSlot(): int
    {
        return $this->slot;
    }

    public function getAssetCode(): AssetCode
    {
        return $this->assetId;
    }
}
