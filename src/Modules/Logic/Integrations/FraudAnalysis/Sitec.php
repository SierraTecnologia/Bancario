<?php

/**
 * anti Fraude inteligente..
 * 
 * Decide qual o melhor anti fraude mandar baseado nas analises anteriores do proprio sistema
 */

namespace Bancario\Modules\Logic\Integrations\FraudAnalysis;

use Bancario\Modules\Logic\Integrations\FraudAnalysis;
use App\Models\User;
use App\Models\Identitys\Customer;
use Bancario\Models\Banks\CreditCard;
use App\Models\Identitys\CustomerToken;
use Bancario\Models\Banks\CreditCardToken;
use App\Models\Shopping\Order;
use Illuminate\Support\Facades\Log;
use Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale;
use Exception;

class Sitec extends FraudAnalysis
{
    public static $ID = 1;
    public static $NAME = 'Sitec';

    protected $fraudAnalysisService = false;

    protected function getConnection($business)
    {
        $this->fraudAnalysisService = new Clearsale($business);
        return $this;
    }

    /**
     * O sitec atua como uma camada superior no anti fraude.
     * E Outro Anti Fraude é utilizado por trás
     */
    public function getFraudAnalysisService()
    {
        return $this->fraudAnalysisService;
    }


    /**
     * Tenta Executar a Cleaar Sale, se falhar, returna true
     */
    public function registerCustomer(CustomerToken &$customerToken)
    {
        Log::debug('Sitec -> Anti Fraude Customer');

        if ($this->isBlockCustomer($customerToken->customer)) {
            Log::critical('[FraudAnalysis] Usuário fraudulento tentnado se registrar');
            return false;
        }

        if ($this->isValidateCustomer($customerToken->customer)) {
            Log::critical('[FraudAnalysis] Usuário Write List. Passando sem anti fraude no registro');
            return true;
        }

        try {
            return $this->getFraudAnalysisService()->registerCustomer($customerToken);
        }
        catch (Exception $e) {
            return true;
        }
    }

    /**
     * Tenta Executar a Cleaar Sale, se falhar, returna true
     */
    public function registerCreditCard(CreditCardToken &$creditCardToken)
    {
        Log::debug('Sitec -> Anti Fraude Cartão de Crédito');
        $creditCard = $creditCardToken->creditCard;

        if ($this->isBlockCreditCard($creditCard)) {
            Log::critical('[FraudAnalysis] Usuário fraudulento tentando comprar');
            return false;
        }

        if ($this->isValidateCreditCard($creditCard)) {
            Log::critical('[FraudAnalysis] Usuário Write List. Passando sem anti fraude');
            return true;
        }

        try {
            return $this->getFraudAnalysisService()->registerCreditCard($creditCardToken);
        }
        catch (Exception $e) {
            return true;
        }
    }

    /**
     * Tenta Executar a Cleaar Sale, se falhar, returna true
     */
    public function registerOrder(Order &$registerOrder)
    {
        Log::debug('Sitec -> Anti Fraude Pedido');

        if ($this->isBlockCustomer($registerOrder->customer) || $this->isBlockCreditCard($registerOrder->creditCard)) {
            Log::critical('[FraudAnalysis] Usuário fraudulento tentando comprar');
            return false;
        }

        if ($this->isValidateCustomer($registerOrder->customer) || $this->isValidateCreditCard($registerOrder->creditCard)) {
            Log::critical('[FraudAnalysis] Usuário Write List. Passando sem anti fraude');
            return true;
        }

        try {
            return $this->getFraudAnalysisService()->registerOrder($registerOrder);
        }
        catch (Exception $e) {
            return true;
        }

        return true;
    }

    /**
     * return bool
     */
    protected function isBlockCustomer(Customer $customer)
    {
        return $customer->score_points<0;
    }

    /**
     * return bool
     */
    protected function isBlockCreditCard(CreditCard $creditCard)
    {
        return $creditCard->score_points<0;
    }

    /**
     * return bool
     */
    protected function isValidateCustomer(Customer $customer)
    {
        return $customer->score_points>0;
    }


    /**
     * return bool
     */
    protected function isValidateCreditCard(CreditCard $creditCard)
    {
        return $creditCard->score_points>0;
    }
}