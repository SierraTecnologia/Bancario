<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Pedreiro\Models\Base;

class Trader extends Base
{
    public static $apresentationName = 'Trader';

    protected $organizationPerspective = true;

    protected $table = 'traders';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
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

    // public function exchange()
    // {
    //     return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_code', 'id');
    // }



    public function exchangeAccounts()
    {
        return $this->hasMany('Bancario\Models\Tradding\ExchangeAccount');
    }

    public function traderTimelines()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderTimeline');
    }
    // public function traddingHistories()
    // {
    //     return $this->hasMany('Bancario\Models\Tradding\TraddingHistory');
    // }
}
