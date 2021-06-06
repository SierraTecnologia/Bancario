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
use Konduto\Core\Konduto as KondutoCore;
use Konduto\Models;
use Exception;

class Konduto extends FraudAnalysis
{
    public static $ID = 3;
    public static $NAME = 'Konduto';

    protected function getConnection($business)
    {
        KondutoCore::setApiKey("T738D516F09CAB3A2C1EE");
    }


    public function registerCustomer(CustomerToken &$customer)
    {
        Log::debug('Konduto -> Anti Fraude Customer');
        return true;
    }

    public function registerCreditCard(CreditCardToken &$creditCard)
    {
        Log::debug('Konduto -> Anti Fraude Cartão de Crédito');
        return true;
    }

    public function updateOrder(Order &$registerOrder)
    {
        // Updates the status of a previously analyzed order
        KondutoCore::updateOrderStatus($registerOrder->id, $registerOrder->status, 'Update order status');
    }

    public function searchOrder(Order &$registerOrder)
    {
        $order = KondutoCore::getOrder($registerOrder->id);
    }

    public function registerOrder(Order &$registerOrder)
    {
        Log::debug('Konduto -> Anti Fraude Pedido');
        
        // $order = new Models\Shopping\Order();
        // $order->setId(uniqid());
        // $order->setVisitor("4738d516f09cab3a2c1ee973bec88a5a367a59e4");
        // $order->setTotalAmount(100.10);
        // $order->setShippingAmount(20.00);
        // $order->setCurrency("USD");

        // $customer = new Models\Identitys\Customer();
        // $customer->setName("Júlia da Silva");
        // $customer->setTaxId("12345678909");
        // $customer->setEmail("jsilva@exemplo.com.br");

        // $order->setCustomer($customer);
        $order = new Models\Shopping\Order(
            array(
            "id" => uniqid(),
            "visitor" => "4738d516f09cab3a2c1ee973bec88a5a367a59e4",
            "total_amount" => 100.10,
            "shipping_amount" => 20.00,
            "tax_amount" => 3.45,
            "currency" => "USD",
            "installments" => 1,
            "ip" => "170.149.100.10",
            "purchased_at" => "2015-04-25T22:29:14Z",
            "customer" => array(
                "id" => "28372",
                "name" => "Júlia da Silva",
                "tax_id" => "12345678909",
                "dob" => "1970-12-25",
                "phone1" => "11-1234-5678",
                "phone2" => "21-2143-6578",
                "email" => "jsilva@exemplo.com.br",
                "created_at" => "2010-12-25",
                "new" => false,
                "vip" => false
            )
            )
        );

        try {
            $analyzedOrder = KondutoCore::analyze($order);
            echo "\nKonduto recommends you to {$order->getRecommendation()} this order.\n";
        }
        catch (Exception $e) {
            echo "\nKonduto wasn't able to return a recommendation: {$e->getMessage()}";
        }
        

        return true;
    }
}