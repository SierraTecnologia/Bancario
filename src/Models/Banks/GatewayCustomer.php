<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;

class GatewayCustomer extends Model
{
    // use ElasticquentTrait;
    use EloquentGetTableNameTrait;

    /**
     * @var true
     */
    protected static bool $organizationPerspective = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'user_id',
        'gateway_id',
        'token'
    ];


    /**
     * @var string[][]
     *
     * @psalm-var array{customer_id: array{type: string, analyzer: string}, user_id: array{type: string, analyzer: string}, gateway_id: array{type: string, analyzer: string}, token: array{type: string, analyzer: string}}
     */
    protected array $mappingProperties = array(

        'customer_id' => [
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


    public function gateway(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('Bancario\Models\Banks\Gateway', 'gateway_id', 'id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Identitys\Customer', 'customer_id', 'id');
    }
}
