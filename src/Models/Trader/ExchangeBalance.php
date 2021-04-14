<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class ExchangeBalance extends Base
{
    public static $apresentationName = 'Balanço nas Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchange_balances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trader_id',
        'exchange_code',
        'money_code',
        'balance_amount_avail',
        'balance_amount_held',
        'balance',
        'btc_balance',
        'last_price',
    ];


    
    public $formFields = [
        // [
        //     'name' => 'exchange_code',
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
            'name' => 'exchange_code',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'money_code',
            'label' => 'Money',
            'type' => 'select',
            'relationship' => 'money'
        ],
        [
            'name' => 'balance_amount_avail',
            'label' => 'balance_amount_avail',
            'type' => 'float'
        ],
        [
            'name' => 'balance_amount_held',
            'label' => 'balance_amount_held',
            'type' => 'float'
        ],
        [
            'name' => 'balance',
            'label' => 'balance',
            'type' => 'float'
        ],
        [
            'name' => 'btc_balance',
            'label' => 'btc_balance',
            'type' => 'float'
        ],
        [
            'name' => 'last_price',
            'label' => 'last_price',
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
        'trader_id',
        'exchange_code',
        'money_code',
        'balance_amount_avail',
        'balance_amount_held',
        'balance',
        'btc_balance',
        'last_price',
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
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_code', 'code');
    }

    public function trader()
    {
        return $this->belongsTo(\Bancario\Models\Trader\Trader::class, 'trader_id', 'id');
    }

    public function money()
    {
        return $this->belongsTo(\Bancario\Models\Money\Money::class, 'money_id', 'id');
    }
}
