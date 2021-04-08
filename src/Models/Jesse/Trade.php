<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Trade extends Base
{
    public static $apresentationName = 'Trades';

    protected $organizationPerspective = true;

    protected $table = 'trade';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'price',
        'buy_qty',
        'sell_qty',
        'buy_count',
        'sell_count',
        'symbol',
        'exchange',
    ];


    
    public $formFields = [
        [
            'name' => 'timestamp',
            'label' => 'timestamp',
            'type' => 'integer'
        ],
        [
            'name' => 'price',
            'label' => 'price',
            'type' => 'float'
        ],
        [
            'name' => 'buy_qty',
            'label' => 'buy_qty',
            'type' => 'float'
        ],
        [
            'name' => 'sell_qty',
            'label' => 'sell_qty',
            'type' => 'float'
        ],
        [
            'name' => 'buy_count',
            'label' => 'buy_count',
            'type' => 'integer'
        ],
        [
            'name' => 'sell_count',
            'label' => 'sell_count',
            'type' => 'integer'
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
        'timestamp',
        'price',
        'buy_qty',
        'sell_qty',
        'buy_count',
        'sell_count',
        'symbol',
        'exchange',
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
