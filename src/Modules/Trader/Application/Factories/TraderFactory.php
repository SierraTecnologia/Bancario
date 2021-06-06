<?php


namespace Bancario\Modules\Trader\Application\Factories;

use Bancario\Modules\Trader\Application\Commands\CreateTraderCommand;
use Bancario\Modules\Trader\Domain\TraderId;
use Bancario\Modules\Trader\Domain\Exchange;
use Bancario\Modules\OpenBanking\Domain\Inventory;
use Bancario\Modules\Trader\Domain\Statistics;
use Bancario\Modules\Trader\Domain\Attributes;
use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Modules\Trader\Domain\Gender;
use Bancario\Modules\Trader\Domain\HitPoints;
use Bancario\Modules\Trader\Domain\Reputation;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class TraderFactory
{
    public function create(
        TraderId $traderId, CreateTraderCommand $command, Exchange $exchange, Collection $assets, Carbon $processingTime, 
        Collection $histories, Collection $orders/*, Inventory $inventory*/): Trader
    {
        return new Trader(
            $traderId,
            $command->getName(),
            $exchange->getId(),
            $assets,
            $command->getIsBacktest(),
            $processingTime,
            // $exchange->getStartingLocationId(),
            // new Gender($command->getGender()),
            // 0,
            // new Reputation(0),
            // new Attributes([
            //     'strength' => $exchange->getStrength(),
            //     'agility' => $exchange->getAgility(),
            //     'constitution' => $exchange->getConstitution(),
            //     'intelligence' => $exchange->getIntelligence(),
            //     'charisma' => $exchange->getCharisma(),
            //     'unassigned' => 0,
            // ]),
            // HitPoints::byExchange($exchange),
            // new Statistics([
            //     'battlesLost' => 0,
            //     'battlesWon' => 0,
            // ]),
            // $inventory,
            // $command->getUserId()
            $histories,
            $orders
        );
    }
}
