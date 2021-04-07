<?php

namespace Bancario\Models\Jesse;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class DailyBalance extends Base
{
    public static $apresentationName = 'Balanço Diário';

    protected $organizationPerspective = true;

    protected $table = 'dailybalance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'identifier',
        'exchange',
        'asset',
        'balance',
    ];


    
    public $formFields = [
        [
            'name' => 'timestamp',
            'label' => 'timestamp',
            'type' => 'integer'
        ],
        [
            'name' => 'identifier',
            'label' => 'identifier',
            'type' => 'integer'
        ],
        [
            'name' => 'asset',
            'label' => 'Asset',
            'type' => 'select',
            'relationship' => 'asset'
        ],
        [
            'name' => 'balance',
            'label' => 'balance',
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
        'timestamp',
        'identifier',
        'exchange',
        'asset',
        'balance',
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
        return $this->belongsTo(\Bancario\Models\Tradding\Exchange::class, 'exchange', 'code');
    }

    /**
     * Par @todo
     */
    public function asset()
    {
        return $this->belongsTo(\Bancario\Models\Money\Money::class, 'asset', 'code');
    }
}
