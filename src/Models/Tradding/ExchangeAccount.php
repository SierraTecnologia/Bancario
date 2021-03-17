<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Pedreiro\Models\Base;

class ExchangeAccount extends Base
{
    public static $apresentationName = 'Contas de Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchange_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'auth_id',
        'exch_name',
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
            'name' => 'auth_id',
            'label' => 'auth_id',
            'type' => 'text'
        ],
        [
            'name' => 'exch_name',
            'label' => 'exch_name',
            'type' => 'text'
        ],
        [
            'name' => 'exchange_id',
            'label' => 'exchange_id',
            'type' => 'text'
        ],
        [
            'name' => 'auth_key',
            'label' => 'auth_key',
            'type' => 'float'
        ],
        [
            'name' => 'auth_secret',
            'label' => 'auth_secret',
            'type' => 'float'
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
        'exch_name',
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
}
