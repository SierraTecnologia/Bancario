<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class TraderHistory extends Base
{
    public static $apresentationName = 'Balanço nas Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'trader_histories';

    public const DEPOSIT = 'deposit';
    public const WITHDRAW = 'withdraw';
    public const SELLING = 'selling';
    public const BUYING = 'buying';

    public const TYPES = [
        self::DEPOSIT,
        self::WITHDRAW,
        self::SELLING,
        self::BUYING,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'processing_time' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trader_id',
        'type',
        'asset_code',
        'value',
        'processing_time',
    ];


    
    public $formFields = [
        // [
        //     'name' => 'exchange_code',
        //     'label' => 'Exchange',
        //     'type' => 'select',
        //     'relationship' => 'exchange'
        // ],
        [
            'name' => 'type',
            'label' => 'type',
            'type' => 'text'
        ],
        [
            'name' => 'trader_id',
            'label' => 'trader_id',
            'type' => 'text'
        ],
        [
            'name' => 'asset_code',
            'label' => 'Asset',
            'type' => 'select',
            'relationship' => 'asset'
        ],
        // [
        //     'name' => 'money_code',
        //     'label' => 'Money',
        //     'type' => 'select',
        //     'relationship' => 'money'
        // ],
        [
            'name' => 'value',
            'label' => 'value',
            'type' => 'float'
        ],
        // [
        //     'name' => 'balance_amount_held',
        //     'label' => 'balance_amount_held',
        //     'type' => 'float'
        // ],
        // [
        //     'name' => 'balance',
        //     'label' => 'balance',
        //     'type' => 'float'
        // ],
        // [
        //     'name' => 'btc_balance',
        //     'label' => 'btc_balance',
        //     'type' => 'float'
        // ],
        // [
        //     'name' => 'last_price',
        //     'label' => 'last_price',
        //     'type' => 'float'
        // ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        ['name' => 'processing_time', 'label' => 'Último Processo', 'type' => 'datetime'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'trader_id',
        'asset_code',
        'value',
        'processing_time'
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
