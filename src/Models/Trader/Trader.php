<?php
/**
 * @todo
 */

namespace Bancario\Models\Trader;

use Pedreiro\Models\Base;
use Muleta\Traits\UsesStringId;
use Illuminate\Support\Facades\DB;
use Bancario\Models\Trader\TraderHistory;

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
        ->orderBy('processing_time', 'DESC');
    }
    public function orders()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderOrder')
        ->orderBy('processing_time', 'DESC');
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





    public function deposits()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderHistory')->select(DB::raw('count(*) as quantify, asset_code, sum(value) as total_value'))
        ->where('type', TraderHistory::DEPOSIT)
        ->groupBy('asset_code')->get();
    }


    public function withdraws()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderHistory')->select(DB::raw('count(*) as quantify, asset_code, sum(value) as total_value'))
        ->where('type', TraderHistory::WITHDRAW)
        ->groupBy('asset_code')->get();
    }

    public function investiments()
    {
        return $this->hasMany('Bancario\Models\Trader\TraderHistory')->select(DB::raw('count(*) as quantify, asset_code, sum(value) as total_value'))
        ->whereIn(
            'type',
            [
                TraderHistory::DEPOSIT,
                TraderHistory::WITHDRAW
            ]
        )
        ->groupBy('asset_code')->get();
    }

    public function metrics()
    {
        // // $data = DB::table("products")
        // return $this->hasMany('Bancario\Models\Trader\TraderHistory')
        //     ->select("trader_histories.asset_code",

        //         DB::raw("(SELECT SUM(trader_histories.value) as total_deposit FROM trader_histories

        //                     WHERE trader_histories.type = '".TraderHistory::DEPOSIT."'

        //                     GROUP BY trader_histories.asset_code) as total_deposits"),

        //         DB::raw("(SELECT SUM(trader_histories.value) as total_deposit FROM trader_histories

        //         WHERE trader_histories.type = '".TraderHistory::WITHDRAW."'

        //         GROUP BY trader_histories.asset_code) as total_withdraws")
        //         // DB::raw("(SELECT SUM(products_sell.sell) FROM products_sell

        //         //             WHERE products_sell.product_id = products.id

        //         //             GROUP BY products_sell.product_id) as product_sell"))
        //     )
        //     ->groupBy('asset_code')->get();
    }
    
}
