<?php

namespace Bancario\Modules\Trader\Application\Contracts;

use Bancario\Modules\Trader\Domain\Exchange;

interface ExchangeRepositoryInterface
{
    public function getOne(string $exchangeCode): Exchange;
}
