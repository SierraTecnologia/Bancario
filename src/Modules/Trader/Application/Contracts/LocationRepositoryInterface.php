<?php

namespace Bancario\Modules\Trader\Application\Contracts;

use Bancario\Modules\Trader\Domain\LocationId;

interface LocationRepositoryInterface
{
    public function nextIdentity(): LocationId;
}
