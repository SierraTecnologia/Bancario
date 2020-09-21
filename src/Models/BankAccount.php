<?php

namespace Bancario\Models;

use Pedreiro\Models\Base;
use Muleta\Traits\Models\ComplexRelationamentTrait;

class BankAccount extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_id',
        'name',
        'agencia',
        'conta',
    ];

    protected $mappingProperties = array(
        'bank_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'agencia' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'conta' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    
    /**
     * Get the owning accountable model.
     */
    public function accountable()
    {
        return $this->morphTo();
    }
}
