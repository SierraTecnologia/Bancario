<?php

namespace Bancario\Entities\Trader;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bancario\Entities\AbstractEntity;

/**
 * Class MoneyEntity.
 *
 * @package Core\Entities
 */
final class MoneyEntity extends AbstractEntity
{
    public $model = \Bancario\Models\Money\Money::class;

    private $code;
    private $name;
    private $description;
    private $symbol;
    private $circulatingSupply;
    private $status;
    // private $createdByUserId;
    // private $balance;
    // private $exchangeAccounts;
    // private $createdAt;
    // private $updatedAt;
    // private $publishedAt;

    /**
     * MoneyEntity constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (isset($attributes['code']) && !is_null($attributes['code'])) {
            $this->setCode($attributes['code']);
        }
        $this->setName($attributes['name'] ?? '');
        $this->setDescription($attributes['description'] ?? '');
        $this->setSymbol($attributes['symbol'] ?? '');
        $this->setCirculatingSupply($attributes['circulating_supply'] ?? 0);
        $this->setStatus($attributes['status'] ?? 1);
        // $this->setCreatedByUserId($attributes['created_by_user_id'] ?? null);
        // $this->setPhoto(new PhotoEntity($attributes['photo'] ?? null));
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
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'symbol' => $this->getSymbol(),
            'circulating_supply' => $this->getCirculatingSupply(),
            'status' => $this->getStatus(),
            // 'exchangeAccounts' => $this->setExchangeAccounts()->toArray(),
            // 'created_by_user_id' => $this->getCreatedByUserId(),
            // 'photo' => $this->getPhoto()->toArray(),
            // 'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->toAtomString() : null,
            // 'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->toAtomString() : null,
            // 'published_at' => $this->getPublishedAt() ? $this->getPublishedAt()->toAtomString() : null,
        ];

        return $attributes;
    }

    /**
     * @param  string $code
     * @return $this
     */
    private function setCode(string $code): MoneyEntity
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param  string $name
     * @return $this
     */
    private function setName(string $name): MoneyEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string $description
     * @return $this
     */
    private function setDescription(string $description): MoneyEntity
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string $symbol
     * @return $this
     */
    private function setSymbol(string $symbol): MoneyEntity
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    
    /**
     * @param  float $quantity
     * @return $this
     */
    private function setCirculatingSupply(float $quantity): MoneyEntity
    {
        $this->circulatingSupply = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getCirculatingSupply(): float
    {
        return $this->circulatingSupply;
    }

    /**
     * @param  string $status
     * @return $this
     */
    private function setStatus(string $status): MoneyEntity
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    // /**
    //  * @param  Collection $exchangeAccounts
    //  * @return $this
    //  */
    // public function setExchangeAccounts(Collection $exchangeAccounts): MoneyEntity
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
    // private function setCreatedByUserId(int $createdByUserId): MoneyEntity
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
    //  * @param  PhotoEntity $photo
    //  * @return $this
    //  */
    // private function setPhoto(PhotoEntity $photo): MoneyEntity
    // {
    //     $this->photo = $photo;

    //     return $this;
    // }

    // /**
    //  * @return PhotoEntity
    //  */
    // public function getPhoto(): PhotoEntity
    // {
    //     return $this->photo;
    // }

    // /**
    //  * @param  Carbon $createdAt
    //  * @return $this
    //  */
    // private function setCreatedAt(Carbon $createdAt): MoneyEntity
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
    // private function setUpdatedAt(Carbon $updatedAt): MoneyEntity
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
    // private function setPublishedAt(?Carbon $publishedAt): MoneyEntity
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
