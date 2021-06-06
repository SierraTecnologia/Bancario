<?php declare(strict_types=1);


namespace Bancario\Modules\OpenBanking\Application\Commands;


use Bancario\Modules\Character\Domain\CharacterId;

class CreateInventoryCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;

    public function __construct(CharacterId $characterId)
    {
        $this->characterId = $characterId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }
}
