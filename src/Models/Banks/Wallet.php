<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;
use BankDb\BankDb;
use Carbon\Carbon;
use BankDb\BankDbException;
use Exception;
use Muleta\Traits\Models\EloquentGetTableNameTrait;

class Wallet extends Model
{
    use EloquentGetTableNameTrait;
    // use ElasticquentTrait;

    protected static $organizationPerspective = false;
    
    protected $dates = ['birth_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf',
        'card_name',
        'holder_id',
        'brand_id',
        'brand_name',
        'phone_country',
        'phone_area_code',
        'phone',
        'birth_date',
        'card_number',
        'exp_year',
        'exp_month',
        'cvc',
        'token',
        'is_verify'
    ];

    protected $mappingProperties = array(

        /**
         * Informações do Dono
         */
        'card_name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'cpf' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'phone_country' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'phone_area_code' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'phone' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'birth_date' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        /**
         * Cartão de Crédito
         */
        'brand_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],
        'brand_name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'card_number' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'exp_year' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'exp_month' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        // CVV
        'cvc' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        // Se esta ativado para Compra ou Bloqueado
        'is_verify' => [
          'type' => 'integer',
          "analyzer" => "standard",
        ],
    );
    
    public function holder()
    {
        return $this->belongsTo('App\Models\Identitys\Customer', 'holder_id', 'id');
    }

    // public function posts()
    // {
    //     return $this->hasManyThrough(
    //         'App\Post',
    //         'App\Models\User',
    //         'country_id', // Foreign key on users table...
    //         'user_id', // Foreign key on posts table...
    //         'id', // Local key on countries table...
    //         'id' // Local key on users table...
    //     );
    // }

    public function analysis()
    {
        return $this->hasMany('App\Models\Identitys\Analysi');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Shopping\Order');
    }

    public function processingFailedPayments()
    {
        return $this->hasMany('App\Models\Shopping\ProcessingFailedPayment');
    }

    /**
     * Get the tokens record associated with the user.
     */
    public function creditCardTokens()
    {
        return $this->hasMany('Bancario\Models\Banks\CreditCardToken', 'credit_card_id', 'id');
    }

    public function validadeParams($params = [])
    {
        //uodate data
        if (!$this->isValid()) {
            return false;
        }

        if (!$this->isVerify()) {
            return $this->updateFromParams($params);
        }

        if (!\Validate\Name::isSame($this->card_name, $params['card_name'])){
            return false;
        }

        if (!\Validate\Birth::isSame($this->birth_date, $params['birth_date'])){
            return false;
        }

        if (!\Validate\Cpf::isSame($this->cpf, $params['cpf'])){
            return false;
        }
        
        // if ($this->is_verify==0) {
        //     return $this->fill($params);
        // }
        return $this->updateFromParams($params);
    }

    /**
     * Se o Cartão foi classificado como Fraude
     */
    public function isBlock()
    {
        // Se estiver fora da data de validação 
        if ($this->is_block != 0){
            return true;
        }

        return false;
    }

    /**
     * Se o Cartão foi verificado e uma compra realizada
     */
    public function isVerify()
    {
        // Se estiver fora da data de validação 
        if ($this->is_verify != 0){
            return true;
        }

        return false;
    }
    

    public function isValid()
    {
        if ($this->isBlock()){
            return false;
        }
        // Se estiver fora da data de validação 
        if (!\Validate\CreditCard::expirationIsValid($this->exp_month, $this->exp_year)){
            return false;
        }

        return true;
    }

    public function getHolder()
    {
        if (is_int($this->holder_id) && $this->holder_id != 0) {
            return true;
        }

        try {
            if ($holder = Customer::where([
                'cpf' => $this->cpf
            ])->first()){
                $this->holder_id = $holder->id;
            }
        } catch (BankDbException $e) {
            return false;
        }
    }

    public function getBrand()
    {
        if (is_int($this->brand_id) && $this->brand_id != 0) {
            return true;
        }

        $card_prefix = $this->card_number; // we only need first 6 digits but it could be the whole card number

        try {
            if (!empty($card_prefix)) {
                $bank_db = new BankDb();
                $bank_info = $bank_db->getBankInfo($card_prefix);

                $brand = CreditCardBrand::firstOrCreate([
                    'is_unknown' => $bank_info->isUnknown(), // is bank unknown
                    'name' => $bank_info->getTitle(true),
                    'color' => $bank_info->getColor(),
                    'type' => $bank_info->getCardType()
                ]);
                $this->brand_name = $bank_info->getTitle(true);

                $this->brand_id = $brand->id;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * Add Novos campos do CArtão caso não existam!
     */
    public function updateFromParams($params = []) {
        $updated = false;

        if (empty($params)) {
            return ;
        }

        // Name
        if (isset($params['card_name']) && !empty($params['card_name']) && $this->card_name!=\Validate\Name::toDatabase($params['card_name'])) {
            $this->card_name = $params['card_name'];
            $updated = true;
        }

        // Cvc
        if (empty($this->cvc) && (isset($params['cvc']) && !empty($params['cvc']))) {
            $this->cvc = $params['cvc'];
            $updated = true;
        }

        // Aniversário do Dono
        if (empty($this->birth_date) && (isset($params['holder_birth_date']) && !empty($params['holder_birth_date']))) {
            if (strlen($params['holder_birth_date'])>8) {
                $this->birth_date = Carbon::createFromFormat('d/m/Y', $params['holder_birth_date']);
            } else {
                $this->birth_date = Carbon::createFromFormat('d/m/y', $params['holder_birth_date']);
            }
            $updated = true;
        }

        // Cpf do Dono
        if (empty($this->cpf) && (isset($params['holder_cpf']) && !empty($params['holder_cpf']))) {
            $this->cpf = $params['holder_cpf'];
            $updated = true;
        }

        // Numero de Telefone do Dono
        if (empty($this->phone) && (isset($params['holder_phone_number']) && !empty($params['holder_phone_number']))) {
            $phoneBreak = \Validate\Phone::break($params['holder_phone_number']);
            $this->phone_country = $phoneBreak['country'];
            $this->phone_area_code = $phoneBreak['region'];
            $this->phone = $phoneBreak['number'];
            $updated = true;
        }

        // Atualizando
        if ($updated) {
            return $this->save();
        }
        return true;
    }
}