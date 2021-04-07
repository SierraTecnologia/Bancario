<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class Config extends Base
{
    public static $apresentationName = 'Endereços de Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'configs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item',
        'value',
        'exchange_code',
    ];


    
    public $formFields = [
        [
            'name' => 'exchange_code',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'item',
            'label' => 'item',
            'type' => 'text'
        ],
        [
            'name' => 'value',
            'label' => 'value',
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
        'exchange_code',
        'item',
        'value',
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


    /**
     * Register events
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                if (is_null($model->trader_id)) {
                    $model->trader_id = Trader::first()->id;
                }
                
            }
        );
    }
}
