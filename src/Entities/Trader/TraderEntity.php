<?php

namespace Bancario\Entities\Trader;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bancario\Entities\AbstractEntity;

/**
 * Class TraderEntity.
 *
 * @package Core\Entities
 */
final class TraderEntity extends AbstractEntity
{
    // public $model = \Bancario\Models\Trader\Trader::class;

    private $id;
    // private $createdByUserId;
    // private $description;
    // private $photo;
    private $exchangeAccounts;
    // private $createdAt;
    // private $updatedAt;
    // private $publishedAt;

    /**
     * TraderEntity constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (isset($attributes['id']) && !is_null($attributes['id'])) {
            $this->setId($attributes['id']);
        }
        // $this->setCreatedByUserId($attributes['created_by_user_id'] ?? null);
        // $this->setDescription($attributes['description'] ?? null);
        // $this->setPhoto(new PhotoEntity($attributes['photo'] ?? null));
        if (isset($attributes['exchange_accounts']) && !empty($attributes['exchange_accounts'])){
            $this->setExchangeAccounts(
                collect($attributes['exchange_accounts'])->map(
                    function (array $attributes) {
                        return new ExchangeAccountEntity($attributes);
                    }
                )
            );
        }
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
            'exchange_accounts' => $this->setExchangeAccounts()->toArray(),
            // 'created_by_user_id' => $this->getCreatedByUserId(),
            // 'description' => $this->getDescription(),
            // 'photo' => $this->getPhoto()->toArray(),
            // 'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->toAtomString() : null,
            // 'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->toAtomString() : null,
            // 'published_at' => $this->getPublishedAt() ? $this->getPublishedAt()->toAtomString() : null,
        ];

        return $attributes;
    }

    /**
     * @param  int $id
     * @return $this
     */
    private function setId(int $id): TraderEntity
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
     * @param  Collection $exchangeAccounts
     * @return $this
     */
    public function setExchangeAccounts(Collection $exchangeAccounts): TraderEntity
    {
        $this->exchangeAccounts = $exchangeAccounts;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getExchangeAccounts(): Collection
    {
        return $this->exchangeAccounts;
    }

    // /**
    //  * @param  int $createdByUserId
    //  * @return $this
    //  */
    // private function setCreatedByUserId(int $createdByUserId): TraderEntity
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
    //  * @param  string $path
    //  * @return $this
    //  */
    // private function setDescription(string $path): TraderEntity
    // {
    //     $this->description = $path;

    //     return $this;
    // }

    // /**
    //  * @return string
    //  */
    // public function getDescription(): string
    // {
    //     return $this->description;
    // }

    // /**
    //  * @param  PhotoEntity $photo
    //  * @return $this
    //  */
    // private function setPhoto(PhotoEntity $photo): TraderEntity
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
    // private function setCreatedAt(Carbon $createdAt): TraderEntity
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
    // private function setUpdatedAt(Carbon $updatedAt): TraderEntity
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
    // private function setPublishedAt(?Carbon $publishedAt): TraderEntity
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
