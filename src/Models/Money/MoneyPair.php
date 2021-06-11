<?php

namespace Bancario\Models\Money;

use Illuminate\Support\Facades\Hash;
use App\Models\Model;

class MoneyPair extends Model
{
    protected $organizationPerspective = false;

    protected $table = 'money_pairs';    

    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';                                                                                           
                                                                                                                                                                                                 
    public $errorMessage = null;                                                                                                                                                                 
                                                                                                                                                                                                 
    public static function rules()                                                                                                                                                               
    {                                                                                                                                                                                            
        return [                                                                                                                                          
            'code' => 'required|slug|max:255',                                                                                                                                                                      
            'name' => 'required|name|max:255',
            'description' => 'required|name|max:255',
            // Volume Transacionado usando a própria moeda
            'symbol' => 'required|name|max:255',
            'circulating_supply' => 'required',                                                                                                                                     
            'status' => 'required|min:0|max:1',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'symbol',
        'circulating_supply',
    ];

    public $indexFields = [
        'name',
        'code',
        'description',
        'status',
        'symbol',
        'circulating_supply',
    ];

    public $formFields = [
        [
            'name' => 'code',
            'label' => 'code',
            'type' => 'text'
        ],
        [
            'name' => 'name',
            'label' => 'name',
            'type' => 'text'
        ],
        [
            'name' => 'description',
            'label' => 'description',
            'type' => 'text'
        ],
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'circulating_supply',
            'label' => 'circulating_supply',
            'type' => 'text'
        ],
        [
            'name' => 'status',
            'label' => 'status',
            'type' => 'text'
        ],
    ];

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
                
                
            }
        );
    }
}