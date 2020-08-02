<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;
use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;

class GatewayCreditCard extends Model
{
    use ElasticquentTrait;
    use EloquentGetTableNameTrait;

    protected $organizationPerspective = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit_card_id',
        'user_id',
        'gateway_id',
        'token'
    ];


    protected $mappingProperties = array(

        'credit_card_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'gateway_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'token' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );


    public function gateway()
    {
        return $this->belongsTo('Bancario\Models\Banks\Gateway', 'gateway_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function creditCard()
    {
        return $this->belongsTo('Bancario\Models\Banks\CreditCard', 'credit_card_id', 'id');
    }
}