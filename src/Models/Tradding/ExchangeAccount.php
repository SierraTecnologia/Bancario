<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Pedreiro\Models\Base;
use Illuminate\Support\Str;

class ExchangeAccount extends Base
{
    public static $apresentationName = 'Contas de Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchange_accounts';

    public $api = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trader_id',
        'exchange_id',
        'auth_key',
        'auth_secret',
        'auth_optional1',
        'auth_nickname',
        'auth_updated',
        'auth_active',
        'auth_trade',
        'exch_trade_enabled',
    ];


    
    public $formFields = [
        // [
        //     'name' => 'exchange_id',
        //     'label' => 'Exchange',
        //     'type' => 'select',
        //     'relationship' => 'exchange'
        // ],
        [
            'name' => 'trader_id',
            'label' => 'trader_id',
            'type' => 'text'
        ],
        [
            'name' => 'exchange_id',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'auth_key',
            'label' => 'auth_key',
            'type' => 'text'
        ],
        [
            'name' => 'auth_secret',
            'label' => 'auth_secret',
            'type' => 'text'
        ],
        [
            'name' => 'auth_optional1',
            'label' => 'auth_optional1',
            'type' => 'float'
        ],
        [
            'name' => 'auth_nickname',
            'label' => 'auth_nickname',
            'type' => 'float'
        ],
        [
            'name' => 'auth_updated',
            'label' => 'auth_updated',
            'type' => 'float'
        ],
        [
            'name' => 'auth_active',
            'label' => 'auth_active',
            'type' => 'float'
        ],
        [
            'name' => 'auth_trade',
            'label' => 'auth_trade',
            'type' => 'float'
        ],
        [
            'name' => 'exch_trade_enabled',
            'label' => 'exch_trade_enabled',
            'type' => 'float'
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
        'auth_id',
        'exchange_id',
        'auth_key',
        'auth_optional1',
        'auth_nickname',
        'auth_updated',
        'auth_active',
        'auth_trade',
        'exch_trade_enabled',
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
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_id', 'id');
    }

    /**
     * Brincando com a Api
     */
    public function getApi()
    {
        if (!$this->api) {
            // @todo Mudar de acordo com a corretora
            $this->api = new \Bancario\Util\Integrations\Exchanges\Binance(
                $this->auth_key,
                $this->auth_secret
            );
        }
        return $this->api;
    }

    public function getBalances()
    {
        return $this->getApi()->getBalances();
    }

    public function getPrice($symbol)
    {
        $price = $this->getApi()->getPrice($symbol);

        $time = time();
        \Bancario\Models\Tradding\TraddingHistory::updateOrCreate(
            [
                'exchange_id' => $this->exchange_id,
                'symbol' => $symbol,
                'time' => $time
            ],
            [
                'exchange_id' => $this->exchange_id,
                'symbol' => $symbol,
                'time' => $time,
                'price' => $price
            ]
        );

        return $price;
    }

    public function getCandlesticks($symbol, $candleSize)
    {
        $ticks = $this->getApi()->getCandlesticks($symbol, $candleSize);
        foreach ($ticks as $tick) {
            $arrayNew = [];
            $arrayNew['exchange_id'] = $this->exchange_id;
            $arrayNew['period'] = $candleSize;
            $arrayNew['symbol'] = $symbol;
            foreach ($tick as $indice=>$value) {
                $arrayNew[Str::snake($indice)] = $value;
            }
            \Bancario\Models\Tradding\Ticker::updateOrCreate(
                [
                    'exchange_id' => $arrayNew['exchange_id'],
                    'period' => $candleSize,
                    'symbol' => $arrayNew['symbol'],
                    'close_time' => $arrayNew['close_time']],
                $arrayNew
            );
        }
        return $ticks;
    }
}
