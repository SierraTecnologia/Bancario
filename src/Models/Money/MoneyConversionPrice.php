<?php
/**
 * Tabela de conversões.
 * Armazena Preços de Cambio de Moeda em diversas fontes.
 */

namespace Bancario\Models\Money;

use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;
use App\Models\Model;

class MoneyConversionPrice extends Model
{
    use EloquentGetTableNameTrait;

    protected static $organizationPerspective = false;

    protected $table = 'money_conversion_prices';                                                                                                                                                                
                                                                                                                                                                                                 
    public $errorMessage = null;                                                                                                                                                                 
                                                                                                                                                                                                 
    public static function rules()                                                                                                                                                               
    {                                                                                                                                                                                            
        return [
            // Moeda a ser avaliado o preço de uma unidade                                                                                                                             
            'money_base_id',                               
            // Moeda usada no preço para comprar uma unidade da moeda comprada                                                                                                       
            'money_target_id',        
            // Fonte da Consulta do preço                                                                                                                            
            'font_id' => 'required|integer',
            // Preço para comprar apenas uma unidade                                                                                                                               
            'price' => 'required|integer',
            // Volume Negociado nas ultimas 24 hrs pela moeda base usando a moeda target para converter                                                                                                        
            'volume' => 'required',
            // Variação do Preço entre as duas moedas
            'change' => 'required',
            // Timestamp Armazenado para Facilidade de Calculos                                                                                                                       
            'time_search' => 'required|integer',
            // Dia armazenado para calculos.
            'date' => 'required|date',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [                                                                                                                                                                
        'money_id',   
        'font_id',
        'price',                                                                     
        'time_search',
        'date'
    ];
}