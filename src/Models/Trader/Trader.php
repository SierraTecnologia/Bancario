<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Pedreiro\Models\Base;
use Muleta\Traits\UsesStringId;

class Trader extends Base
{
    use UsesStringId;
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
        'name',
        'exchange_code',
        'is_backtest',
        'processing_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_backtest' => 'boolean',
        'processing_time' => 'datetime',
    ];

    
    public $formFields = [
        // [
        //     'name' => 'id',
        //     'label' => 'Exchange',
        //     'type' => 'select',
        //     'relationship' => 'exchange'
        // ],
        ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
        ['name' => 'exchange_code', 'label' => 'Exchange', 'type' => 'select', 'relationship' => 'exchange'],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        ['name' => 'is_backtest', 'label' => 'Publish Date', 'type' => 'boolean'],
        ['name' => 'processing_time', 'label' => 'Processing Date', 'type' => 'datetime'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'id',
        'exchange_code',
        'is_backtest',
        'processing_time',
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



    public function exchange()
    {
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange_code', 'code');
    }

    /**
     * Get all of the assets for the post.
     */
    public function assets()
    {
        return $this->morphToMany(Asset::class, 'assetable')
            ->withTimestamps()
            ->withPivot('value')
            ->orderBy('assetables.value');
    }
    public function histories()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderHistory')
        ->orderBy('processing_time');
    }



    /**
     * @todo
     */
    public function exchangeAccounts()
    {
        return $this->hasMany('Bancario\Models\Tradding\ExchangeAccount');
    }

    public function traderTimelines()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderTimeline');
    }
    
}
