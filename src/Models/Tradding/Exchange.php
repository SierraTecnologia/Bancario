<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Exchange extends Base
{
    public static $apresentationName = 'Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchanges';
    
    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exchange',
        'ccxt',
        'coinigy',
        'coinigy_id',
        'coinigy_exch_code',
        'coinigy_exch_fee',
        'coinigy_trade_enabled',
        'coinigy_balance_enabled',
        'hasFetchTickers',
        'hasFetchOHLCV',
        'use',
        'data',
        'url',
        'url_api',
        'url_doc',
    ];


    
    public $formFields = [
        [
            'name' => 'name',
            'label' => 'name',
            'type' => 'text'
        ],
        [
            'name' => 'ccxt',
            'label' => 'ccxt',
            'type' => 'text'
        ],
        [
            'name' => 'coinigy',
            'label' => 'coinigy',
            'type' => 'text'
        ],
        [
            'name' => 'coinigy_id',
            'label' => 'coinigy_id',
            'type' => 'float'
        ],
        [
            'name' => 'coinigy_exch_code',
            'label' => 'coinigy_exch_code',
            'type' => 'float'
        ],
        [
            'name' => 'coinigy_exch_fee',
            'label' => 'coinigy_exch_fee',
            'type' => 'float'
        ],
        [
            'name' => 'coinigy_trade_enabled',
            'label' => 'coinigy_trade_enabled',
            'type' => 'float'
        ],
        [
            'name' => 'coinigy_balance_enabled',
            'label' => 'coinigy_balance_enabled',
            'type' => 'float'
        ],
        [
            'name' => 'hasFetchTickers',
            'label' => 'hasFetchTickers',
            'type' => 'float'
        ],
        [
            'name' => 'hasFetchOHLCV',
            'label' => 'hasFetchOHLCV',
            'type' => 'float'
        ],
        [
            'name' => 'use',
            'label' => 'use',
            'type' => 'float'
        ],
        [
            'name' => 'data',
            'label' => 'data',
            'type' => 'float'
        ],
        [
            'name' => 'url',
            'label' => 'url',
            'type' => 'float'
        ],
        [
            'name' => 'url_api',
            'label' => 'url_api',
            'type' => 'float'
        ],
        [
            'name' => 'url_doc',
            'label' => 'url_doc',
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
        'id',
        'name',
        // 'ccxt',
        // 'coinigy',
        // 'coinigy_id',
        // 'coinigy_exch_code',
        // 'coinigy_exch_fee',
        // 'coinigy_trade_enabled',
        // 'coinigy_balance_enabled',
        'hasFetchTickers',
        'hasFetchOHLCV',
        'use',
        // 'data',
        // 'url',
        'url_api',
        'url_doc',
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

    // public function exchange()
    // {
    //     return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_code', 'id');
    // }
}
