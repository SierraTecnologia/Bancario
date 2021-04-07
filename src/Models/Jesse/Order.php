<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Order extends Base
{
    public static $apresentationName = 'orders';

    protected $organizationPerspective = true;

    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trade_id',
        'exchange_id',
        'vars',
        'symbol',
        'exchange',
        'side',
        'type',
        'flag',
        'qty',
        'price',
        'status',
        'created_at',
        'executed_at',
        'canceled_at',
        'role',
    ];


    
    public $formFields = [

        [
            'name' => 'vars',
            'label' => 'vars',
            'type' => 'json'
        ],
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'exchange',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'side',
            'label' => 'side',
            'type' => 'text'
        ],
        [
            'name' => 'type',
            'label' => 'type',
            'type' => 'text'
        ],
        [
            'name' => 'flag',
            'label' => 'flag',
            'type' => 'text'
        ],
        [
            'name' => 'qty',
            'label' => 'qty',
            'type' => 'float'
        ],
        [
            'name' => 'price',
            'label' => 'price',
            'type' => 'float'
        ],
        [
            'name' => 'status',
            'label' => 'status',
            'type' => 'integer'
        ],
        [
            'name' => 'created_at',
            'label' => 'created_at',
            'type' => 'integer'
        ],
        [
            'name' => 'executed_at',
            'label' => 'executed_at',
            'type' => 'integer'
        ],
        [
            'name' => 'canceled_at',
            'label' => 'canceled_at',
            'type' => 'integer'
        ],
        [
            'name' => 'role',
            'label' => 'role',
            'type' => 'text'
        ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        // ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'trade_id',
        'exchange_id',
        'vars',
        'symbol',
        'exchange',
        'side',
        'type',
        'flag',
        'qty',
        'price',
        'status',
        'created_at',
        'executed_at',
        'canceled_at',
        'role',
    ];

    public $validationRules = [
        // 'name'       => 'required|max:255',
        // 'url'        => 'required|max:100',
        // 'status'        => 'boolean',
        // // 'publish_on'  => 'date',
        // // 'published'   => 'boolean',
        // // 'category_id' => 'required|int',
    ];

    public $validationMessages = [
        // 'name.required' => "Nome é obrigatório."
    ];

    public $validationAttributes = [
        // 'name' => 'Name'
    ];

    public function exchange()
    {
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange', 'code');
    }

    /**
     * Par @todo
     */
    public function symbol()
    {
        return $this->belongsTo(\Bancario\Models\Money\Pair::class, 'symbol', 'code');
    }
}
