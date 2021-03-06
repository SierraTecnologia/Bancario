<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;
use Bancario\Builders\CandleBuilder;

class Candle extends Base
{
    public static $classeBuilder = CandleBuilder::class;

    public static $apresentationName = 'Candles';

    protected $organizationPerspective = true;

    protected $table = 'candle';
    
    public $timestamps = false;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
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
        'open_at',
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
        ['name' => 'open_at', 'label' => 'Date', 'type' => 'date'],
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
        'open_at',
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




    /**
     * @inheritdoc
     */
    public function newEloquentBuilder($query): CandleBuilder
    {
        return new CandleBuilder($query);
    }

    /**
     * @inheritdoc
     */
    public function newQuery(): CandleBuilder
    {
        return parent::newQuery();
    }

    // /**
    //  * @return CandleEntity
    //  */
    // public function toEntity(): CandleEntity
    // {
    //     return new CandleEntity(
    //         [
    //         'id' => $this->id,
    //         'value' => $this->value,
    //         ]
    //     );
    // }
}
