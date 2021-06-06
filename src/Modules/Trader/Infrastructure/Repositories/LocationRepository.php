<?php

namespace Bancario\Modules\Trader\Infrastructure\Repositories;

use Bancario\Modules\Trader\Application\Contracts\LocationRepositoryInterface;
use Bancario\Modules\Trader\Domain\LocationId;
use Muleta\Traits\GeneratesUuid;
use Exception;

class LocationRepository implements LocationRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @return LocationId
     *
     * @throws Exception
     */
    public function nextIdentity(): LocationId
    {
        return LocationId::fromString($this->generateUuid());
    }
}
