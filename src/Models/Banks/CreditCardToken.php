<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Muleta\Traits\Models\EloquentGetTableNameTrait;

use App\Logic\Integrations\Gateways\Mundipagg;
use Illuminate\Support\Facades\Log;

use App\Util\Validate;
use App\Util\Filter;
use App\Util\General;
use Carbon\Carbon;
use App\Http\Requests\CreditCardRequest;

class CreditCardToken extends Model
{
    // use ElasticquentTrait;
    use EloquentGetTableNameTrait;

    protected static $organizationPerspective = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_token_id',
        'credit_card_id',
        'user_id',
        'token',
        'company_token',
        'is_active'
    ];

    protected $mappingProperties = array(

        'customer_id' => [
          'type' => 'id',
          "analyzer" => "standard",
        ],

        'credit_card_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],

        'token' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],

        'company_token' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        'is_active' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
    );

    public function customerToken()
    {
        return $this->belongsTo('App\Models\Identitys\Customer', 'customer_id', 'id');
    }

    public function customer()
    {
        return $this->hasManyThrough('App\Models\Identitys\Customer', 'App\Models\Identitys\CustomerToken');
    }

    public function creditCard()
    {
        return $this->belongsTo('Bancario\Models\Banks\CreditCard', 'credit_card_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Shopping\Order');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public static function returnOrCreateByParams($params, $companyToken, $business)
    {

        if(!is_array($params) || !isset($params['token'])) {
            return false;
        }
        if(!isset($params['card_number'])) {
            return false;
        }
        if(!isset($params['cpf']) && !isset($params['user_token'])) {
            Log::warning('[Register Order] Erro ao Criar cartão de crédito durante pedido. Sem Cpf ou User Token');
            return false;
        }
        if(isset($params['cpf']) && !$customer = Customer::where('cpf', \Validate\Cpf::validate($params['cpf']))->first()) {
            Log::warning(
                '[Register Order] Erro ao Criar cartão de crédito durante pedido. '.
                'Usuário não encontrado pelo cpf'
            );
            return false;
        }
        
        $customerToken = false;
        if(isset($params['user_token']) && !$customerToken = CustomerToken::where('token', $params['user_token'])->first()) {
            if (!$customerToken = CustomerToken::returnOrCreateByParams($params, $companyToken, $business)) {
                Log::warning(
                    '[Register Order] Erro ao Criar cartão de crédito durante pedido. '.
                    'Usuário não encontrado pelo user token'
                );
                return false;
            }
        }
        if ($customerToken) {
            $customer = $customerToken->customer;
        }

        $creditCard = CreditCard::where('card_number', $params['card_number'])->first();
        if($creditCard && $creditCardToken = CreditCardToken::where('company_token', $params['token'])->where('credit_card_id', $creditCard->id)->first()) {
            $creditCardToken->updateFromParams($params);
            return [$creditCard, $creditCardToken];
        }

        if (!$creditCard) {
            $params['cpf'] = \Validate\Cpf::validate($customer->cpf);
            $creditCard = CreditCard::create(
                CreditCardRequest::filterParams($params)
            );
        }

        if ( !is_object($business)) {
            // @todo Gambiarra Sinistra, resolver depois
            Log::notice(
                'Não deveria estar vindo sem ser um objeto!'.
                var_dump($_GET, true).
                var_dump($_POST, true)
            );
            $business = User::where('token', '3a0cafad9715806584cf60bf6c04200a');
        }

        if (isset($params['gateway_mundipagg']) && !empty($params['gateway_mundipagg'])) {
            $gatewayCreditCard = new GatewayCreditCard();
            $gatewayCreditCard->token = $params['gateway_mundipagg'];
            $gatewayCreditCard->customer_id = $customer->id;
            $gatewayCreditCard->credit_card_id = $creditCard->id;
            $gatewayCreditCard->gateway_id = Mundipagg::$ID;
            $gatewayCreditCard->user_id = $business->id;
            $customer->gatewayCreditCards()->save($gatewayCreditCard);
        }

        // @todo @fixme Sempre cria o Token ?? Vai dar ruim !
        $creditCardToken = new CreditCardToken();
        $creditCardToken->customer_id = $customer->id;
        $creditCardToken->company_token = $params['token'];
        $creditCardToken->is_active = 1;
        $creditCardToken->credit_card_id = $creditCard->id;
        $creditCardToken->user_id = $business->id;
        $creditCard->creditCardTokens()->save($creditCardToken);
        $creditCardToken->updateFromParams($params);

        return [$creditCard, $creditCardToken];
    }

    public function validadeParams($params = [])
    {
        if (empty($params)) {
            return false;
        }

        return $this->customer->validadeParams($params);
    }



    /**
     * Add Novos campos do CArtão caso não existam!
     */
    public function updateFromParams($params = []) {

        if (empty($params)) {
            return ;
        }

        return $this->creditCard->updateFromParams($params);
    }
}