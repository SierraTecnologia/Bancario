<?php
/**
 * @todo
 */

namespace Bancario\Models\Tradding;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class ExchangeAddress extends Base
{
    public static $apresentationName = 'Endereços de Exchanges';

    protected $organizationPerspective = true;

    protected $table = 'exchange_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exchange_code',
        'currency',
        'address',
    ];


    
    public $formFields = [
        [
            'name' => 'exchange_code',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'currency',
            'label' => 'currency',
            'type' => 'text'
        ],
        [
            'name' => 'address',
            'label' => 'address',
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
        'currency',
        'address',
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
