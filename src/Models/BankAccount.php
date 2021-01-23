<?php

namespace Bancario\Models;

use Pedreiro\Models\Base;
use Muleta\Traits\Models\ComplexRelationamentTrait;
use Telefonica\Models\Digital\Password;

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
        'password_id',
        'obs',
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
    /**
     * Get all of the passwords for the post.
     */
    public function passwords()
    {
        return $this->morphToMany(Password::class, 'passwordable');
    }
}
