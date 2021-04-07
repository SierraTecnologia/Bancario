<?php
/**
 * @todo
 */

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class CompletedTrade extends Base
{
    public static $apresentationName = 'Trades Completados';

    protected $organizationPerspective = true;

    protected $table = 'completedtrade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'strategy_name',
        'symbol',
        'exchange',
        'type',
        'timeframe',
        'entry_price',
        'exit_price',
        'take_profit_at',
        'stop_loss_at',
        'qty',
        'opened_at',
        'closed_at',
        'entry_candle_timestamp',
        'exit_candle_timestamp',
        'leverage',
    ];


    
    public $formFields = [
        [
            'name' => 'strategy_name',
            'label' => 'Estratégia',
            'type' => 'select',
            'relationship' => 'strategy'
        ],
        [
            'name' => 'symbol',
            'label' => 'Par de Moedas',
            'type' => 'select',
            'relationship' => 'symbol'
        ],
        [
            'name' => 'exchange',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'type',
            'label' => 'type',
            'type' => 'text'
        ],
        [
            'name' => 'timeframe',
            'label' => 'timeframe',
            'type' => 'text'
        ],
        [
            'name' => 'entry_price',
            'label' => 'entry_price',
            'type' => 'float'
        ],
        [
            'name' => 'exit_price',
            'label' => 'exit_price',
            'type' => 'float'
        ],
        [
            'name' => 'take_profit_at',
            'label' => 'take_profit_at',
            'type' => 'float'
        ],
        [
            'name' => 'stop_loss_at',
            'label' => 'stop_loss_at',
            'type' => 'float'
        ],
        [
            'name' => 'qty',
            'label' => 'qty',
            'type' => 'float'
        ],
        [
            'name' => 'opened_at',
            'label' => 'opened_at',
            'type' => 'integer'
        ],
        [
            'name' => 'closed_at',
            'label' => 'closed_at',
            'type' => 'integer'
        ],
        [
            'name' => 'entry_candle_timestamp',
            'label' => 'entry_candle_timestamp',
            'type' => 'integer'
        ],
        [
            'name' => 'exit_candle_timestamp',
            'label' => 'exit_candle_timestamp',
            'type' => 'integer'
        ],
        [
            'name' => 'leverage',
            'label' => 'leverage',
            'type' => 'integer'
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
        'strategy_name',
        'symbol',
        'exchange',
        'type',
        'timeframe',
        'entry_price',
        'exit_price',
        'take_profit_at',
        'stop_loss_at',
        'qty',
        'opened_at',
        'closed_at',
        'entry_candle_timestamp',
        'exit_candle_timestamp',
        'leverage',
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
     * Register events
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                // if (is_null($model->trader_id)) {
                //     $model->trader_id = Trader::first()->id;
                // }
                
            }
        );
    }
}
