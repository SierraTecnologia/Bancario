<?php

namespace Bancario\Modules\OpenBanking\Application\Contracts;

use Bancario\Modules\Character\Domain\CharacterId;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\OpenBanking\Domain\InventoryId;

interface InventoryRepositoryInterface
{
    public function nextIdentity(): InventoryId;

    public function add(Inventory $inventory): void;

    public function forCharacter(CharacterId $characterId): Inventory;

    public function update(Inventory $inventory): void;
}
