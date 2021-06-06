<?php

/**
 * Documentação
 * http://docs.konduto.com/pt/#enviar-um-pedido/
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
use Exception;

class Pagseguro extends FraudAnalysis
{
    public static $ID = 4;
    public static $NAME = 'Pagseguro';

    protected function getConnection($business)
    {
        return true;
    }


    public function registerCustomer(CustomerToken &$customer)
    {
        Log::debug('Pagseguro -> Anti Fraude Customer');
        return true;
    }

    public function registerCreditCard(CreditCardToken &$creditCard)
    {
        Log::debug('Pagseguro -> Anti Fraude Cartão de Crédito');
        return true;
    }

    public function registerOrder(Order &$registerOrder)
    {
        Log::debug('Pagseguro -> Anti Fraude Pedido');
        return true;
    }
}