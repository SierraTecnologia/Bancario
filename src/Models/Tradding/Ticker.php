<?php

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Ticker extends Base
{
    public static $apresentationName = 'Servidores';

    protected $organizationPerspective = true;

    protected $table = 'tickers';

    /**
     * The attributes that should be cast.
     * array
     * boolean
     * collection
     * date
     * datetime
     * decimal:<digits>
     * double
     * encrypted
     * encrypted:array
     * encrypted:collection
     * encrypted:object
     * float
     * integer
     * object
     * real
     * string
     * timestamp
     *
     * @var array
     */
    protected $casts = [
        'open_time' => 'timestamp',
        'ignored' => 'boolean',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exchange_code',
        'symbol',
        'period',
        'open_time',
        'datetime',
        'high',
        'low',
        'bid',
        'ask',
        'vwap',
        'open',
        'close',
        'first',
        'last',
        'change',
        'percentage',
        'average',
        'base_volume',
        'quotevolume',
    ];


    
    public $formFields = [
        [
            'name' => 'exchange_code',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'period',
            'label' => 'period',
            'type' => 'text'
        ],
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'open_time',
            'label' => 'open_time',
            'type' => 'text'
        ],
        [
            'name' => 'datetime',
            'label' => 'datetime',
            'type' => 'text'
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
            'name' => 'bid',
            'label' => 'bid',
            'type' => 'float'
        ],
        [
            'name' => 'ask',
            'label' => 'ask',
            'type' => 'float'
        ],
        [
            'name' => 'vwap',
            'label' => 'vwap',
            'type' => 'float'
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
            'name' => 'first',
            'label' => 'first',
            'type' => 'float'
        ],
        [
            'name' => 'last',
            'label' => 'last',
            'type' => 'float'
        ],
        [
            'name' => 'change',
            'label' => 'change',
            'type' => 'float'
        ],
        [
            'name' => 'percentage',
            'label' => 'percentage',
            'type' => 'float'
        ],
        [
            'name' => 'average',
            'label' => 'average',
            'type' => 'float'
        ],
        [
            'name' => 'base_volume',
            'label' => 'base_volume',
            'type' => 'float'
        ],
        [
            'name' => 'quotevolume',
            'label' => 'quotevolume',
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
        'exchange_code',
        'symbol',
        'period',
        'open_time',
        'datetime',
        'high',
        'low',
        'bid',
        'ask',
        'vwap',
        'open',
        'close',
        'first',
        'last',
        'change',
        'percentage',
        'average',
        'base_volume',
        'quotevolume',
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
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_code', 'id');
    }
}
