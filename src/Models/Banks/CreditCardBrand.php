<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;


use Muleta\Traits\Models\EloquentGetTableNameTrait;

class CreditCardBrand extends Model
{
    use EloquentGetTableNameTrait;
    // use ElasticquentTrait;

    /**
     * @var false
     */
    protected static bool $organizationPerspective = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
        'type',
        'is_unknown',
    ];

    /**
     * @var string[][]
     *
     * @psalm-var array{name: array{type: string, analyzer: string}, color: array{type: string, analyzer: string}, type: array{type: string, analyzer: string}, is_unknown: array{type: string, analyzer: string}}
     */
    protected array $mappingProperties = array(
        'name' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'color' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'type' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'is_unknown' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
    );

    public function creditCards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('Bancario\Models\Banks\CreditCard');
    }
}