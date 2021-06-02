<?php


namespace Bancario\Modules\Trader\Application\Services;


use Bancario\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use Bancario\Modules\Battle\Domain\Battle;
use Bancario\Modules\Battle\Domain\BattleId;
use Bancario\Modules\Battle\Domain\BattleRounds;
use Bancario\Modules\Trader\Application\Contracts\ExchangeRepositoryInterface;
use Bancario\Modules\Trader\Domain\TraderId;
use Bancario\Modules\Trader\Application\Contracts\TraderRepositoryInterface;
use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Modules\Trader\Application\Commands\AttackTraderCommand;
use Bancario\Modules\Trader\Application\Commands\CreateTraderCommand;
use Bancario\Modules\Trader\Application\Commands\IncreaseAttributeCommand;
use Bancario\Modules\Trader\Application\Commands\MoveTraderCommand;
use Bancario\Modules\Trader\Application\Factories\TraderFactory;
use Bancario\Modules\OpenBanking\Application\Commands\CreateInventoryCommand;
use Bancario\Modules\OpenBanking\Application\Services\InventoryService;
use Bancario\Modules\Image\Domain\Image;
use Bancario\Modules\Level\Application\Services\LevelService;
use Bancario\Modules\Trade\Application\Commands\CreateStoreCommand;
use Bancario\Modules\Trade\Application\Services\StoreService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class TraderService
{
    /**
     * @var TraderFactory
     */
    private $traderFactory;
    /**
     * @var TraderRepositoryInterface
     */
    private $traderRepository;
    /**
     * @var ExchangeRepositoryInterface
     */
    private $exchangeRepository;
    // /**
    //  * @var BattleRepositoryInterface
    //  */
    // private $battleRepository;
    // /**
    //  * @var LevelService
    //  */
    // private $levelService;
    // /**
    //  * @var InventoryService
    //  */
    // private $inventoryService;
    // /**
    //  * @var StoreService
    //  */
    // private $storeService;

    public function __construct(
        TraderFactory $traderFactory,
        TraderRepositoryInterface $traderRepository,
        ExchangeRepositoryInterface $exchangeRepository
        // BattleRepositoryInterface $battleRepository,
        // LevelService $levelService,
        // InventoryService $inventoryService,
        // StoreService $storeService
    )
    {
        $this->traderFactory = $traderFactory;
        $this->traderRepository = $traderRepository;
        $this->exchangeRepository = $exchangeRepository;
        // $this->battleRepository = $battleRepository;
        // $this->levelService = $levelService;
        // $this->inventoryService = $inventoryService;
        // $this->storeService = $storeService;
    }

    public function create(CreateTraderCommand $command): Trader
    {
        $traderId = $this->traderRepository->nextIdentity();

        $exchange = $this->exchangeRepository->getOne($command->getExchangeCode());
        // $inventory = $this->inventoryService->create(new CreateInventoryCommand($traderId));
        // $this->storeService->create(new CreateStoreCommand($traderId));

        $trader = $this->traderFactory->create(
            $traderId, $command, $exchange, Collection::make(), Carbon::now()
            // $inventory
        );

        $this->traderRepository->add($trader);

        return $trader;
    }

    public function increaseAttribute(IncreaseAttributeCommand $command): void
    {
        $trader = $this->traderRepository->getOne($command->getTraderId());

        $trader->applyAttributeIncrease($command->getAttribute());

        $this->traderRepository->update($trader);
    }

    public function move(MoveTraderCommand $command): void
    {
        $trader = $this->traderRepository->getOne($command->getTraderId());

        $trader->setLocationId($command->getLocationId());

        $this->traderRepository->update($trader);
    }

    public function attack(AttackTraderCommand $command): BattleId
    {
        return DB::transaction(function () use ($command) {

            $attacker = $this->traderRepository->getOne($command->getAttackerId());
            $defender = $this->traderRepository->getOne($command->getDefenderId());

            $battleId = $this->battleRepository->nextIdentity();

            $battle = new Battle(
                $battleId,
                $defender->getLocationId(),
                $attacker,
                $defender,
                new BattleRounds(),
                0
            );

            $battle->execute();

            $victor = $battle->getVictor();
            $loser = $battle->getLoser();

            $victor->incrementWonBattles();
            $loser->incrementLostBattles();

            $victor->addXp($battle->getVictorXpGained());

            $newLevel = $this->levelService->getLevelByXp($victor->getXp());

            $victor->updateLevel($newLevel->getId());

            $this->traderRepository->update($victor);
            $this->traderRepository->update($loser);
            $this->battleRepository->add($battle);

            return $battleId;
        });
    }

    public function updateProfilePicture(Image $picture): void
    {
        $trader = $this->traderRepository->getOne($picture->getTraderId());

        $trader->setProfilePictureId($picture->getId());

        $this->traderRepository->update($trader);
    }

    public function removeProfilePicture(TraderId $traderId): void
    {
        $trader = $this->traderRepository->getOne($traderId);

        $trader->removeProfilePicture();

        $this->traderRepository->update($trader);
    }
}
