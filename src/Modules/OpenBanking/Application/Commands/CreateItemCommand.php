<?php

namespace Bancario\Modules\OpenBanking\Application\Commands;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\AssetPrototypeId;

class CreateAssetCommand
{
    /**
     * @var AssetPrototypeId
     */
    private $prototypeId;
    /**
     * @var CharacterId
     */
    private $creatorCharacterId;

    public function __construct(AssetPrototypeId $prototypeId, CharacterId $creatorCharacterId)
    {
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
    }

    public function getPrototypeId(): AssetPrototypeId
    {
        return $this->prototypeId;
    }

    public function getCreatorCharacterId(): CharacterId
    {
        return $this->creatorCharacterId;
    }
}
