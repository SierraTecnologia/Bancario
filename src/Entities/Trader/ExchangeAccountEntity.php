<?php

namespace Bancario\Entities\Trader;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bancario\Entities\AbstractEntity;

/**
 * Class ExchangeAccountEntity.
 *
 * @package Core\Entities
 */
final class ExchangeAccountEntity extends AbstractEntity
{
    // public $model = \Bancario\Models\Tradding\ExchangeAccount::class;

    private $id;
    // private $createdByUserId;
    // private $description;
    // private $photo;
    // private $tags;
    // private $createdAt;
    // private $updatedAt;
    // private $publishedAt;

    /**
     * ExchangeAccountEntity constructor.
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
        // $this->setTags(
        //     collect($attributes['tags'])->map(
        //         function (array $attributes) {
        //             return new TagEntity($attributes);
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
            // 'created_by_user_id' => $this->getCreatedByUserId(),
            // 'description' => $this->getDescription(),
            // 'photo' => $this->getPhoto()->toArray(),
            // 'tags' => $this->getTags()->toArray(),
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
    private function setId(int $id): ExchangeAccountEntity
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

    // /**
    //  * @param  int $createdByUserId
    //  * @return $this
    //  */
    // private function setCreatedByUserId(int $createdByUserId): ExchangeAccountEntity
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
    // private function setDescription(string $path): ExchangeAccountEntity
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
    // private function setPhoto(PhotoEntity $photo): ExchangeAccountEntity
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
    //  * @param  Collection $tags
    //  * @return $this
    //  */
    // public function setTags(Collection $tags): ExchangeAccountEntity
    // {
    //     $this->tags = $tags;

    //     return $this;
    // }

    // /**
    //  * @return Collection
    //  */
    // public function getTags(): Collection
    // {
    //     return $this->tags;
    // }

    // /**
    //  * @param  Carbon $createdAt
    //  * @return $this
    //  */
    // private function setCreatedAt(Carbon $createdAt): ExchangeAccountEntity
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
    // private function setUpdatedAt(Carbon $updatedAt): ExchangeAccountEntity
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
    // private function setPublishedAt(?Carbon $publishedAt): ExchangeAccountEntity
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
