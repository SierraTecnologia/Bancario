<?php

namespace Bancario\Modules\Trader\Infrastructure\Repositories;

use Bancario\Modules\Trader\Application\Contracts\ExchangeRepositoryInterface;
// use Bancario\Modules\Trader\Domain\Attributes;
use Bancario\Modules\Trader\Domain\Exchange;
use Bancario\Models\Tradding\Exchange as ExchangeModel;

class ExchangeRepository implements ExchangeRepositoryInterface
{
    public function getOne(string $exchangeCode): Exchange
    {
        /** @var ExchangeModel $exchange */
        $exchange = ExchangeModel::query()->findOrFail($exchangeCode);

        return new Exchange(
            $exchange->getId(),
            // $exchange->getStartingLocationId(),
            $exchange->getName()
            // $exchange->getDescription(),
            // $exchange->getMaleImage(),
            // $exchange->getFemaleImage(),
            // new Attributes([
            //     'strength' => $exchange->getStrength(),
            //     'agility' => $exchange->getAgility(),
            //     'constitution' => $exchange->getConstitution(),
            //     'intelligence' => $exchange->getIntelligence(),
            //     'charisma' => $exchange->getCharisma(),
            // ])
        );
    }
}
