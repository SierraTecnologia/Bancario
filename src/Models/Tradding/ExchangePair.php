<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class ExchangePair extends Base
{
    public static $apresentationName = 'Pares de Moedas aceitas Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchange_pairs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exchange_id',
        'market_id',
        'exchange_pair',
    ];


    
    public $formFields = [
        [
            'name' => 'exchange_id',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'market_id',
            'label' => 'Market',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'exchange_pair',
            'label' => 'exchange_pair',
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
        'exchange_id',
        'market_id',
        'exchange_pair',
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

    /**
     * Register events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {

                // \Bancario\Models\Money\Money::firstOrCreate(
                //     [
                //     // 'id'              => Role::$GOOD,
                //     'name'            => 'Good'
                //     ]
                // );
                // $timelineModel = new \Casa\Models\Historic\Timeline();
                // $timelineModel->timestamp = $model->timestamp;
                // $timelineModel->timelineable_id = $model->localizationable_id;
                // $timelineModel->timelineable_type = $model->localizationable_type;
                // $timelineModel->save();

                // $model->timeline_id = $timelineModel->id;
            }
        );
    }
}
