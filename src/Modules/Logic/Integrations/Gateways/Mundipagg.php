<?php
/**
 * Integração com Mundipagg
 * https://github.com/mundipagg/MundiAPI-PHP
 */

namespace Bancario\Modules\Logic\Integrations\Gateways;

use Bancario\Modules\Logic\Integrations\Gateways;
use App\Models\Identitys\CustomerToken;
use Bancario\Models\Banks\CreditCardToken;
use App\Models\Shopping\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use DateTime;
use DatePeriod;
use DateInterval;
use MundiAPILib\Models\CreateCardRequest;
use MundiAPILib\MundiAPIClient;
use MundiAPILib\Models\CreateAddressRequest;
use MundiAPILib\Models\CreateChargeRequest;
use MundiAPILib\Models\CreatePaymentRequest;
use MundiAPILib\Models\CreateCreditCardPaymentRequest;

class Mundipagg extends Gateways
{
    public static $ID = 1;
    public static $NAME = 'Mundipagg';

    protected function getConnection(User $business)
    {
        Log::debug('[Mundipagg] Se conectando com pv-'. $business->gateway_mundipagg_public. '- E key: -'. $business->gateway_mundipagg_secret.'-');
        return new \MundiAPILib\MundiAPIClient($business->gateway_mundipagg_secret, $business->gateway_mundipagg_public);
    }

    public function isErrorByInsufficientFunds()
    {
        return false;
    }

    public function registerCustomer(CustomerToken &$customer)
    {
        Log::info('Mundipagg -> Registrando Customer');
        return true;
    }

    public function registerCreditCard(CreditCardToken &$creditCard)
    {
        Log::info('Mundipagg -> Registrando Cartão de Crédito');
        return true;
    }

    public function registerOrder(Order &$registerOrder)
    {
        Log::info('Mundipagg -> Registrando Pedido para Cpf:'.$registerOrder->customer->cpf);
        
        $this->error = 'Compra não autorizada';
        $this->errorCode = 0;
        $this->errorMessage = 'Não identificado';

        return false;
        // $body = new CreateOrderRequest();

        // $result = $orders->createOrder($body);

        // return true;

        // CUSTOMER
        $createAddressRequest = new \MundiAPILib\Models\CreateAddressRequest();

        // Load CustomerInfo
        $createAddressRequest->street       = $registerOrder->billing_address;
        $createAddressRequest->number       = $registerOrder->billing_number; // acho que nao temos
        $createAddressRequest->complement   = $registerOrder->complement;
        $createAddressRequest->neighborhood = $registerOrder->neighborhood; // acho que nao temos
        $createAddressRequest->city         = $registerOrder->city;
        $createAddressRequest->state        = $registerOrder->state;
        $createAddressRequest->country      = $registerOrder->country; // acho que nao temos, tem que ser 'BRA'
        $createAddressRequest->zipCode      = $registerOrder->zipcode;
        $createAddressRequest->metadata     = ['address_attr' => 'data'];

        $createHomePhoneRequest = new \MundiAPILib\Models\CreatePhoneRequest();

        // Load CustomerInfo
        $createHomePhoneRequest->countryCode = $registerOrder->countryCode; // acho nao temos, tem que ser 55
        $createHomePhoneRequest->areaCode    = $registerOrder->areaCode; // acho que nao temos, para RJ 21
        $createHomePhoneRequest->number      = $registerOrder->phoneNumber; // acho que nao temos,
        
        $createMobilePhoneRequest = new \MundiAPILib\Models\CreatePhoneRequest();

        // Load CustomerInfo
        $createMobilePhoneRequest->countryCode = $registerOrder->mobileCountryCode; // acho nao temos, tem que ser 55
        $createMobilePhoneRequest->areaCode    = $registerOrder->mobileCountryCode; // acho que nao temos, para RJ 21
        $createMobilePhoneRequest->number      = $registerOrder->mobilePhoneNumber; // acho que nao temos
        
        $createPhonesRequest = new \MundiAPILib\Models\CreatePhonesRequest();
        // Load Classses
        $createPhonesRequest->homePhone   = $createHomePhoneRequest;
        $createPhonesRequest->mobilePhone = $createMobilePhoneRequest;
        
        $createCustomerRequest = new \MundiAPILib\Models\CreateCustomerRequest();
        // Load Classses
        $createCustomerRequest->address     = $createAddressRequest;
        $createCustomerRequest->phones      = $createPhonesRequest;

        // Load CustomerInfo
        $createCustomerRequest->code        = 'CUSTOMER_INTEGRATION_CODE';
        $createCustomerRequest->type        = 'individual';
        $createCustomerRequest->name        = $registerOrder->customer->name;
        $createCustomerRequest->email       = $registerOrder->customer->email;
        $createCustomerRequest->document    = $registerOrder->customer->cpf;
        $createCustomerRequest->gender      = $registerOrder->customer->gender; // acho que não temos, 'male' or 'female'
        $createCustomerRequest->birthdate   = $registerOrder->customer->birthday; // acho que não temos, '1982-06-03'
        $createCustomerRequest->metadata    = ['customer_attr' => 'data'];

        // DUE DATE
        $dueDate = new DateTime('now');
        $dueDate->add(new DateInterval('P3D')); // Add 3 days

        // CREDIT CARD
        $createCardRequest = new \MundiAPILib\Models\CreateCardRequest();
        $createCardRequest->number     = $registerOrder->creditCard->card_number;
        $createCardRequest->holderName = $registerOrder->creditCard->card_name;
        $createCardRequest->expMonth   = $registerOrder->creditCard->exp_month;
        $createCardRequest->expYear    = $registerOrder->creditCard->exp_year;
        $createCardRequest->cvv        = $registerOrder->creditCard->cvc;

        $createCreditCardPaymentRequest = new \MundiAPILib\Models\CreateCreditCardPaymentRequest();
        $createCreditCardPaymentRequest->card         = $createCardRequest;
        $createCreditCardPaymentRequest->installments = 1; // missing info
        $createCreditCardPaymentRequest->capture      = true; // true for auth and capture
        
        $createPaymnentRequest = new \MundiAPILib\Models\CreatePaymentRequest();
        $createPaymnentRequest->creditCard    = $createCreditCardPaymentRequest;
        $createPaymnentRequest->paymentMethod = 'credit_card';
        $createPaymnentRequest->metadata      = ['payment_attr' => 'data'];

        // CHARGE
        $createChargeRequest = new \MundiAPILib\Models\CreateChargeRequest();
        $createChargeRequest->customer = $createCustomerRequest;
        $createChargeRequest->payment  = $createPaymnentRequest;
        $createChargeRequest->code     = 'CHARGE_INTEGRATION_CODE'; // If not informed, a random code is generated
        $createChargeRequest->dueAt    = $dueDate;
        $createChargeRequest->currency = 'BRL';
        $createChargeRequest->amount   = 100;  // In cents
        $createChargeRequest->metadata = ['charge_attr' => 'data'];

        $charges = $this->_connection->getCharges();

        $result = $charges->createCharge($createChargeRequest);
        
        var_dump($result);

        return true;
    }
}