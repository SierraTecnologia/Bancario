<?php

namespace Bancario\Modules\Trader\Application\Contracts;

use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Modules\Trader\Domain\TraderId;

interface TraderRepositoryInterface
{
    public function nextIdentity(): TraderId;

    public function add(Trader $trader): void;

    public function getOne(TraderId $traderId): Trader;

    public function update(Trader $trader): void;
}
