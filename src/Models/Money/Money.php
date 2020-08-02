<?php

namespace Bancario\Models\Money;

use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;
use App\Models\Model;

class Money extends Model
{
    use EloquentGetTableNameTrait;

    protected static $organizationPerspective = false;

    /**
     * Tipos de Moeda ()
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static $BRAZILIAN_REAL = 1;

    protected $table = 'moneys';                                                                                               
                                                                                                                                                                                                 
    public $errorMessage = null;                                                                                                                                                                 
                                                                                                                                                                                                 
    public static function rules()                                                                                                                                                               
    {                                                                                                                                                                                            
        return [                                                                                                                                                                                 
            'name' => 'required|name|max:255',                                                                                                                                    
            'slug' => 'required|slug|max:255',
            // Simbolo de 3 letras: Real (BRL), Bitcoin (BTC)                                                                                                                                
            'symbol' => 'required|slug|max:255',
            // Volume Transacionado usando a própria moeda
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
        'slug',
        'description',
        'status',
    ];
}