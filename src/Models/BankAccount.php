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
        'proprietario',
        'type',
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

    public $formFields = [
        [
            'name' => 'proprietario',
            'label' => 'proprietario',
            'type' => 'text'
        ],
        [
            'name' => 'type',
            'label' => 'type',
            'type' => 'text'
        ],
        [
            'name' => 'agencia',
            'label' => 'agencia',
            'type' => 'text'
        ],
        [
            'name' => 'conta',
            'label' => 'conta',
            'type' => 'text'
        ],
        // [
        //     'name' => 'slug',
        //     'label' => 'slug',
        //     'type' => 'text'
        // ],
        // [
        //     'name' => 'status',
        //     'label' => 'Status',
        //     'type' => 'checkbox'
        // ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        // ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        ['name' => 'bank_id', 'label' => 'Bank', 'type' => 'select', 'relationship' => 'bank'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'bank_id',
        'proprietário',
        'type',
        'agencia',
        'conta'
        // 'slug',
        // 'status'
    ];
    
    
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
    
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
