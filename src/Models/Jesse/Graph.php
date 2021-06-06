<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Graph extends Base
{
    public static $apresentationName = 'Graphs';

    protected $organizationPerspective = true;

    protected $table = 'graphs';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'open',
        'close',
        'high',
        'low',
        'volume',
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
            'name' => 'open',
            'label' => 'open',
            'type' => 'float'
        ],
        [
            'name' => 'close',
            'label' => 'close',
            'type' => 'float'
        ],
        [
            'name' => 'high',
            'label' => 'high',
            'type' => 'float'
        ],
        [
            'name' => 'low',
            'label' => 'low',
            'type' => 'float'
        ],
        [
            'name' => 'volume',
            'label' => 'volume',
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
        'open',
        'close',
        'high',
        'low',
        'volume',
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


    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInExchange($query, $exchangeCode)
    {
        return $query->where('exchange', $exchangeCode);
    }
    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPair($query, $pair)
    {
        return $query->where('symbol', $pair);
    }
}
