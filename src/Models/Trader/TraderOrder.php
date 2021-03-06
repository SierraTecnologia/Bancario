<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Pedreiro\Models\Base;

class TraderOrder extends Base
{
    public static $apresentationName = 'Trader Orders';

    protected $organizationPerspective = true;

    protected $table = 'trader_orders';
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'processing_time' => 'datetime',
        'vars' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'trader_id',
        'asset_seller_code',
        'asset_buyer_code',
        'value',
        'price',
        'taxa',
        'processing_time',
        'vars',
    ];
    
    public $formFields = [
        [
            'name' => 'id',
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
        'id',
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

    public function trader()
    {
        return $this->belongsTo(\Bancario\Models\Trader\Trader::class, 'trader_id', 'id');
    }

}
