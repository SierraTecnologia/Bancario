<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;


use Muleta\Traits\Models\EloquentGetTableNameTrait;

class CreditCardBrand extends Model
{
    use EloquentGetTableNameTrait;
    // use ElasticquentTrait;

    protected static $organizationPerspective = false;

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

    protected $mappingProperties = array(
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

    public function creditCards()
    {
        return $this->hasMany('Bancario\Models\Banks\CreditCard');
    }
}