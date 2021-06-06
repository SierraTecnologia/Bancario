<?php

namespace Bancario\Modules\Trader\Infrastructure\Repositories;

use Bancario\Modules\Trader\Application\Contracts\TraderRepositoryInterface;
use Bancario\Modules\Trader\Domain\Trader;
use Bancario\Models\Trader\Trader as TraderModel;
use Bancario\Modules\Trader\Domain\TraderId;
use Bancario\Modules\Trader\Infrastructure\ReconstitutionFactories\TraderReconstitutionFactory;
use Muleta\Traits\GeneratesUuid;
use Exception;
// use Muleta\Modules\Eloquents\Displays\RepositoryAbstract;

class TraderRepository implements TraderRepositoryInterface
{
    use GeneratesUuid;

    public function model()
    {
        return TraderModel::class;
    }

    /**
     * @var TraderReconstitutionFactory
     */
    private $traderReconstitutionFactory;

    public function __construct(TraderReconstitutionFactory $traderReconstitutionFactory)
    {
        $this->traderReconstitutionFactory = $traderReconstitutionFactory;
    }

    /**
     * @return TraderId
     *
     * @throws Exception
     */
    public function nextIdentity(): TraderId
    {
        return TraderId::fromString($this->generateUuid());
    }

    public function add(Trader $trader): void
    {
        // $profilePictureId = $trader->getProfilePictureId();

        /** @var TraderModel $traderModel */
        TraderModel::query()->create([
            'id' => $trader->getId()->toString(),
            // 'user_id' => $trader->getUserId(),

            'name' => $trader->getName(),
            // 'gender' => $trader->getGender()->getValue(),

            // 'xp' => $trader->getXp(),
            // 'level_id' => $trader->getLevelNumber(),
            // 'reputation' => $trader->getReputation()->getValue(),

            // 'strength' => $trader->getStrength(),
            // 'agility' => $trader->getAgility(),
            // 'constitution' => $trader->getConstitution(),
            // 'intelligence' => $trader->getIntelligence(),
            // 'charisma' => $trader->getCharisma(),

            // 'hit_points' => $trader->getHitPoints(),
            // 'total_hit_points' => $trader->getTotalHitPoints(),

            'exchange_code' => $trader->getExchangeCode(),
            // 'assets' => $trader->getAssets(),
            'is_backtest' => $trader->getIsBacktest(),
            'processing_time' => $trader->getProcessingTime(),
            // 'location_id' => $trader->getLocationId(),

            // 'battles_won' => $trader->getBattlesWon(),
            // 'battles_lost' => $trader->getBattlesLost(),

            // 'profile_picture_id' => $profilePictureId ? $profilePictureId->toString() : null,
        ]);
    }

    public function getOne(TraderId $traderId): Trader
    {
        /** @var TraderModel $traderModel */
        $traderModel = TraderModel::query()->with('assets')->findOrFail($traderId->toString());

        return $this->traderReconstitutionFactory->reconstitute($traderModel);
    }

    public function update(Trader $trader): void
    {
        /** @var TraderModel $traderModel */
        $traderModel = TraderModel::query()->findOrFail($trader->getId()->toString());

        $traderModel->update([
            'id' => $trader->getId()->toString(),
            // 'user_id' => $trader->getUserId(),

            'name' => $trader->getName(),
            // 'gender' => $trader->getGender()->getValue(),

            // 'xp' => $trader->getXp(),
            // 'level_id' => $trader->getLevelNumber(),
            // 'reputation' => $trader->getReputation()->getValue(),

            // 'strength' => $trader->getStrength(),
            // 'agility' => $trader->getAgility(),
            // 'constitution' => $trader->getConstitution(),
            // 'intelligence' => $trader->getIntelligence(),
            // 'charisma' => $trader->getCharisma(),

            // 'hit_points' => $trader->getHitPoints(),
            // 'total_hit_points' => $trader->getTotalHitPoints(),

            'exchange_code' => $trader->getExchangeCode(),
            // 'assets' => $trader->getAssets(),
            'is_backtest' => $trader->getIsBacktest(),
            'processing_time' => $trader->getProcessingTime(),
            // 'location_id' => $trader->getLocationId(),

            // 'battles_won' => $trader->getBattlesWon(),
            // 'battles_lost' => $trader->getBattlesLost(),

            // 'profile_picture_id' => $profilePictureId ? $profilePictureId->toString() : null,
        ]);
    }
}
