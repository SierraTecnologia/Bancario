<?php

namespace Bancario\Entities\Trader;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bancario\Entities\AbstractEntity;

/**
 * Class WalletEntity.
 *
 * @package Core\Entities
 */
final class WalletEntity extends AbstractEntity
{
    // public $model = \Bancario\Models\Tradding\Wallet::class;

    private $id;
    // private $createdByUserId;
    // private $description;
    private $balance;
    private $exchangeAccounts;
    // private $createdAt;
    // private $updatedAt;
    // private $publishedAt;

    /**
     * WalletEntity constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (isset($attributes['id']) && !is_null($attributes['id'])) {
            $this->setId($attributes['id']);
        }
        // $this->setCreatedByUserId($attributes['created_by_user_id'] ?? null);
        $this->setBalance($attributes['balance'] ?? null);
        $this->setMoney(new MoneyEntity($attributes['money'] ?? null));
        // $this->setExchangeAccounts(
        //     collect($attributes['exchangeAccounts'])->map(
        //         function (array $attributes) {
        //             return new ExchangeAccountEntity($attributes);
        //         }
        //     )
        // );
        // $this->setCreatedAt(isset($attributes['created_at']) ? new Carbon($attributes['created_at']) : null);
        // $this->setUpdatedAt(isset($attributes['updated_at']) ? new Carbon($attributes['updated_at']) : null);
        // $this->setPublishedAt(isset($attributes['published_at']) ? new Carbon($attributes['published_at']) : null);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $attributes = [
            'id' => $this->getId(),
            'balance' => $this->getBalance(),
            'money' => $this->getMoney()->toArray(),
            // 'exchangeAccounts' => $this->setExchangeAccounts()->toArray(),
            // 'created_by_user_id' => $this->getCreatedByUserId(),
            // 'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->toAtomString() : null,
            // 'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->toAtomString() : null,
            // 'published_at' => $this->getPublishedAt() ? $this->getPublishedAt()->toAtomString() : null,
        ];

        return $attributes;
    }

    /************************************************************
     *            Propriedades
     ***********************************************************/

    /**
     * @param  float $quantity
     * @return $this
     */
    public function removeFromBalance(float $quantity): WalletEntity
    {
        $this->balance -= $quantity;

        return $this;
    }

    /**
     * @param  float $quantity
     * @return $this
     */
    public function addToBalance(float $quantity): WalletEntity
    {
        $this->balance += $quantity;

        return $this;
    }

    /************************************************************
     *            GETTERS   AND    SETTERS
     ***********************************************************/

    /**
     * @param  int $id
     * @return $this
     */
    private function setId(int $id): WalletEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  float $quantity
     * @return $this
     */
    private function setBalance(float $quantity): WalletEntity
    {
        $this->balance = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param  MoneyEntity $money
     * @return $this
     */
    private function setMoney(MoneyEntity $money): WalletEntity
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @return MoneyEntity
     */
    public function getMoney(): MoneyEntity
    {
        return $this->money;
    }

    // /**
    //  * @param  Collection $exchangeAccounts
    //  * @return $this
    //  */
    // public function setExchangeAccounts(Collection $exchangeAccounts): WalletEntity
    // {
    //     $this->exchangeAccounts = $exchangeAccounts;

    //     return $this;
    // }

    // /**
    //  * @return Collection
    //  */
    // public function getExchangeAccounts(): Collection
    // {
    //     return $this->exchangeAccounts;
    // }

    // /**
    //  * @param  int $createdByUserId
    //  * @return $this
    //  */
    // private function setCreatedByUserId(int $createdByUserId): WalletEntity
    // {
    //     $this->createdByUserId = $createdByUserId;

    //     return $this;
    // }

    // /**
    //  * @return int
    //  */
    // public function getCreatedByUserId(): int
    // {
    //     return $this->createdByUserId;
    // }



    // /**
    //  * @param  Carbon $createdAt
    //  * @return $this
    //  */
    // private function setCreatedAt(Carbon $createdAt): WalletEntity
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

    // /**
    //  * @return Carbon
    //  */
    // public function getCreatedAt(): Carbon
    // {
    //     return $this->createdAt;
    // }

    // /**
    //  * @param  Carbon $updatedAt
    //  * @return $this
    //  */
    // private function setUpdatedAt(Carbon $updatedAt): WalletEntity
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }

    // /**
    //  * @return Carbon
    //  */
    // public function getUpdatedAt(): Carbon
    // {
    //     return $this->updatedAt;
    // }

    // /**
    //  * @param  Carbon|null $publishedAt
    //  * @return $this
    //  */
    // private function setPublishedAt(?Carbon $publishedAt): WalletEntity
    // {
    //     $this->publishedAt = $publishedAt;

    //     return $this;
    // }

    // /**
    //  * @return Carbon|null
    //  */
    // public function getPublishedAt(): ?Carbon
    // {
    //     return $this->publishedAt;
    // }

    // /**
    //  * @return bool
    //  */
    // public function isPublished(): bool
    // {
    //     return (bool) $this->getPublishedAt();
    // }

}
