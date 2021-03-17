<?php

namespace Bancario\Entities;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Class AbstractEntity.
 *
 * @package Core\Entities
 */
abstract class AbstractEntity implements Arrayable, JsonSerializable
{

    public static function init(array $array = [])
    {
        return new static($array);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * persist
     *
     * @return bool
     */
    private function persist()
    {
        $this->model::create($this->toArray());
    }
}
