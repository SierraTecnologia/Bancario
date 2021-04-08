<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Ticker extends Base
{
    public static $apresentationName = 'Tickers';

    protected $organizationPerspective = true;

    protected $table = 'ticker';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'last_price',
        'volume',
        'high_price',
        'low_price',
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
            'name' => 'last_price',
            'label' => 'last_price',
            'type' => 'float'
        ],
        [
            'name' => 'volume',
            'label' => 'volume',
            'type' => 'float'
        ],
        [
            'name' => 'high_price',
            'label' => 'high_price',
            'type' => 'float'
        ],
        [
            'name' => 'low_price',
            'label' => 'low_price',
            'type' => 'float'
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
        'last_price',
        'volume',
        'high_price',
        'low_price',
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
