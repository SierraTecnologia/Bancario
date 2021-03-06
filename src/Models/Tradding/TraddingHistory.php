<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Pedreiro\Models\Base;

class TraddingHistory extends Base
{
    public static $apresentationName = 'Histórico de Preço';

    protected $organizationPerspective = true;

    protected $table = 'tradding_histories';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exchange_code',
        'symbol',
        'price',
        'time',
    ];


    
    public $formFields = [
        [
            'name' => 'exchange_code',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'price',
            'label' => 'price',
            'type' => 'float'
        ],
        [
            'name' => 'time',
            'label' => 'time',
            'type' => 'timestamp'
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
        'price',
        'time',
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
