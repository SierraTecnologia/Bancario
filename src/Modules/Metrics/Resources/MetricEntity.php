<?php

namespace Bancario\Modules\Metrics\Resources;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class MetricEntity.
 *
 * @package Core\Entities
 */
final class MetricEntity extends \Muleta\Modules\Eloquents\Displays\EntityAbstract
{
    private $code;
    private $name;
    private $color;
    private $value;
    // private $tags;
    // private $createdAt;
    // private $updatedAt;
    // private $publishedAt;

    /**
     * MetricEntity constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (!is_null($attributes['code'])) {
            $this->setCode($attributes['code']);
        }
        $this->setName($attributes['name'] ?? null);
        $this->setColor($attributes['color'] ?? null);
        $this->setValue($attributes['value'] ?? null);
    }

    /**
     * @param  string $code
     * @return $this
     */
    private function setCode(string $code): MetricEntity
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
    private function setName(string $name): MetricEntity
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
     * @param  string $color
     * @return $this
     */
    private function setColor(string $color): MetricEntity
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param  $value
     * @return $this
     */
    private function setValue($value): MetricEntity
    {
        $this->value = $value;

        return $this;
    }

    /**
     * 
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $attributes = [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'color' => $this->getColor(),
            'value' => $this->getValue(),
        ];

        return $attributes;
    }
}
