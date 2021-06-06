<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class PopularExchange extends Base
{
    public static $apresentationName = 'Exchanges Populares';

    protected $organizationPerspective = true;

    protected $table = 'popular_exchanges';
    
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
        // 'exchange_code',
        'public_api',
        'coinigy',
        'ccxt',
        'link',
        'about',
    ];


    
    public $formFields = [
        // [
        //     'name' => 'exchange_code',
        //     'label' => 'Exchange',
        //     'type' => 'select',
        //     'relationship' => 'exchange'
        // ],
        [
            'name' => 'public_api',
            'label' => 'public_api',
            'type' => 'text' // boolean
        ],
        [
            'name' => 'coinigy',
            'label' => 'coinigy',
            'type' => 'text' // boolean
        ],
        [
            'name' => 'ccxt',
            'label' => 'ccxt',
            'type' => 'text' // boolean
        ],
        [
            'name' => 'link',
            'label' => 'link',
            'type' => 'text'
        ],
        [
            'name' => 'about',
            'label' => 'about',
            'type' => 'text'
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
        // 'exchange_code',
        'symbol',
        'timestamp',
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
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'code', 'code');
    }
}
