<?php
/**
 * Integração com Pagseguro
 * Doc. Especial -> https://dev.pagseguro.uol.com.br/docs/checkout-web-usando-a-sua-tela-backend
 */

namespace Bancario\Modules\Logic\Integrations\Gateways;

use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;
use App\Util\Filter;

use PHPSC\PagSeguro\Customer\Customer as CustomerGateway;
use PHPSC\PagSeguro\Customer\Phone as PhoneGateway;
use PHPSC\PagSeguro\Customer\Address as AddressGateway;
use PHPSC\PagSeguro\Items\Item as ItemGateway;
use PHPSC\PagSeguro\Items\ItemCollection as ItemCollectionGateway;
use PHPSC\PagSeguro\Shipping\Shipping as ShippingGateway;
use PHPSC\PagSeguro\Purchases\Transactions\Payment as PaymentGateway;
use PHPSC\PagSeguro\Purchases\Transactions\PaymentMethod as PaymentMethodGateway;
use PHPSC\PagSeguro\Purchases\Transactions\Transaction as OrderGateway;
use PHPSC\PagSeguro\Purchases\Details as DetailsGateway;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;

use Bancario\Modules\Logic\Integrations\Gateways;
use App\Models\Identitys\Customer;
use Bancario\Models\Banks\GatewayCreditCard;
use App\Models\Identitys\CustomerToken;
use Bancario\Models\Banks\CreditCardToken;
use App\Models\Shopping\Order;
use App\Models\User;
use App\Models\Shopping\ItemOrder;
use Bancario\Models\Money\PaymentType;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Date;
use Exception;
use SimpleXMLElement;


/**
 * Classe Responsável pelo pagseguro
 *
 * @todo Fazer
 */
class Pagseguro extends Gateways
{
    public static $ID = 3;
    public static $NAME = 'Pagseguro';
    public $sessionId = null;

    public $validateErrors = [];

    public $remoteErros = [
        [
            'code' => 53099,
            'message' => 'extra amount invalid pattern: 0. Must fit the patern: -?\\\\d+.\\\\d{2}',
        ],
        [
            'code' => 53078,
            'message' => 'item amount invalid pattern: 200. Must fit the patern: \\\\d+.\\\\d{2}',
        ],
        [
            'code' => 53102,
            'message' => 'payment method invalid value, valid values are credit_card, boleto and online_debit.',
        ],
        [
            'code' => 53037,
            'message' => 'credit card token is required.',
        ],
        [
            'code' => 53066,
            'message' => 'billing address country is required.',
        ],
        [
            'code' => 53047,
            'message' => 'credit card holder birthdate is required.',
        ],
        [
            'code' => 53040,
            'message' => 'installment value is required.',
        ],
        [
            'code' => 53064,
            'message' => 'billing address state is required.',
        ],
        [
            'code' => 53060,
            'message' => 'billing address district is required.',
        ],
        [
            'code' => 53049,
            'message' => 'credit card holder area code is required.',
        ],
        [
            'code' => 53053,
            'message' => 'billing address postal code is required.',
        ],
        [
            'code' => 53038,
            'message' => 'installment quantity is required.',
        ],
        [
            'code' => 53062,
            'message' => 'billing address city is required.',
        ],
        [
            'code' => 53057,
            'message' => 'billing address number is required.',
        ],
        [
            'code' => 53042,
            'message' => 'credit card holder name is required.',
        ],
        [
            'code' => 53051,
            'message' => 'credit card holder phone is required.',
        ],
        [
            'code' => 53045,
            'message' => 'credit card holder cpf is required.',
        ],
        [
            'code' => 53055,
            'message' => 'billing address street is required.',
        ]
    ];

    public function validateForTransaction()
    {
        // @todo
        // Verificar se possui endereço

        // VErificae se possui telefone

        // VErificar nome ta completo

        // Verificar Aniversario do dono do cartao
        return true;
    }

    protected function getLoginParams()
    {
        return 'email='.$this->user->gateway_pagseguro_public.'&token='.$this->user->gateway_pagseguro_secret;
    }

    protected function getWsHost()
    {
        if ($this->isProduction()) {
            return 'https://ws.pagseguro.uol.com.br/';
        }
        return 'https://ws.sandbox.pagseguro.uol.com.br/';
    }

    protected function getDfHost()
    {
        if ($this->isProduction()) {
            return 'https://df.uol.com.br/';
        }
        return 'https://df.uol.com.br/';
    }
    
    protected function getConnection(User $business)
    {
        if ($this->isProduction()) {
            Log::debug(
                '[Pagseguro] Produção User:'. $business->gateway_pagseguro_public.
                ' Token:'. $business->gateway_pagseguro_secret
            );
            return new Credentials(
                $business->gateway_pagseguro_public, //'EMAIL CADASTRADO NO PAGSEGURO',
                $business->gateway_pagseguro_secret, //'TOKEN DE ACESSO À API',
                new Production()
            );
        }

        Log::debug(
            '[Pagseguro] Teste User:'. $business->gateway_pagseguro_public.
            ' Token:'. $business->gateway_pagseguro_secret
        );

        /* Ambiente de testes: */
        return new Credentials(
            $business->gateway_pagseguro_public, //'EMAIL CADASTRADO NO PAGSEGURO',
            $business->gateway_pagseguro_secret,
            new Sandbox()
        );
    }

    public function getSession()
    {
        $result = $this->postXml($this->getWsHost().'v2/sessions?'.$this->getLoginParams());
        return (string) $result->id;
    }

    public function isErrorByInsufficientFunds()
    {
        return false;
    }

    public function registerOrder(Order &$registerOrder)
    {
        try {
            // Token tem que ser gerado para cada compra
            // if (empty($registerOrder->creditCardToken->creditCard->token)) {
            //     Log::info('RICARDAO DEBUG: Gerando Token pra cartao de credito ja que nao tem!');
                // Verificar se ja capturou o token nos ultimos X minutos
                Log::info('RICARDAO DEBUG: Gerando Token pra cartao de credito ja que nao tem!');
            if ($registerOrder->creditCardToken) {
                $creditCardToken = $this->registerCreditCard($registerOrder->creditCardToken, $registerOrder->total);
                if (empty($creditCardToken)) {
                    Log::critical('Problema no cadastro de cartão na pagseguro');
                    throw new Exception("Problema no cadastro de cartão na pagseguro", 406);
                    return false;
                }
            }
            // }
            Log::info('RICARDAO DEBUG: Gerando Pedido!');
            $orderGateway = $this->fromOrderModel($registerOrder, $creditCardToken);
            /**
             *  WAITING_PAYMENT = '1';o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
             *  UNDER_ANALYSIS = '2';o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
             *  PAID = '3'; a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
             *  AVAILABLE = '4';a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
             *  UNDER_CONTEST = '5';  o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
             *  RETURNED = '6'; o valor da transação foi devolvido para o comprador.
             *  CANCELLED = '7'; a transação foi cancelada sem ter sido finalizada.
             *  Debitado = '8'; o valor da transação foi devolvido para o comprador.
             *  Retenção temporária: = '9'; o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
             */
            $registerOrder->gateway_id = self::$ID;
            Log::info('RICARDAO DEBUG: Retornando token!');
            // Caso Exista Código do Pedido
            if (isset($orderGateway->code)) {
                $registerOrder->gateway_token_pagseguro = (string) $orderGateway->code;
            }
            // Caso Exista Código do Pedido
            if (isset($orderGateway->paymentLink) && !empty($orderGateway->paymentLink)) {
                $registerOrder->payment_link = (string) $orderGateway->paymentLink;
            }
            // Tratando Status
            if ((string) $orderGateway->status == '3' || (string) $orderGateway->status == '4') {
                Log::info('[Pagseguro Pedido] Transação Autorizada com sucesso! Valor: '.$registerOrder->total.' Tid: '. $orderGateway->code);
                $registerOrder->status = Order::$STATUS_APPROVED;
            } else if ((string) $orderGateway->status == '2') {
                Log::info('[Pagseguro Pedido] Transação Em analise! Valor: '.$registerOrder->total.' Tid: '. $orderGateway->code);
                $registerOrder->status = Order::$STATUS_ANALYSIS;
            } else if ((string) $orderGateway->status == '1') {
                Log::info('[Pagseguro Pedido] Transação Pendente Pagamento! Valor: '.$registerOrder->total.' Tid: '. $orderGateway->code);
                $registerOrder->status = Order::$STATUS_PEDDING_PAYMENT;
            } else if ((string) $orderGateway->status == '5' || (string) $orderGateway->status == '6' || (string) $orderGateway->status == '8' || (string) $orderGateway->status == '9') {
                Log::info('[Pagseguro Pedido] Transação Com charge Back! Valor: '.$registerOrder->total.' Tid: '. $orderGateway->code);
                $registerOrder->status = Order::$STATUS_FRAUD_WITH_LOSS;
            } else {
                Log::info('[Pagseguro Pedido] Transação Reprovada! Valor: '.$registerOrder->total.' Tid: '. $orderGateway->code);
                $registerOrder->status = Order::$STATUS_REPROVED;
            }
            return true;
        } catch (Exception $error) {
            // Caso ocorreu algum erro
            // $xml = new SimpleXMLElement($error->getMessage());
            if ($this->isValidXml($error->getMessage())) {
                Log::info(
                    'Erro em XMl:', [
                    'erro' => $error->getMessage(),
                    $this->xmlDeserialize($error->getMessage())
                    ]
                );
            } else {
                Log::info(
                    'SemXMl', [
                    'erro' => $error->getMessage(),
                    'error' => $error
                    ]
                );
            }

            $this->error = $error->getMessage();
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
            Log::warning(
                '[Pagseguro] Compra nao Passou!',
                [
                        'code' => $error->getMessage()
                   ]
            );
            return false;
        }

        $this->error = 'Compra não autorizada';
        $this->errorCode = 0;
        $this->errorMessage = 'Não identificado';
        return false;
    }

    public function registerCustomer(CustomerToken &$customer)
    {
        return true;
    }
    // [2019-04-11 17:11:14] testing.INFO: Fazendo requisição https://df.uol.com.br/v2/cards?email=pagseguro@passepague.com.br&token=7899389154E840EF8B442E60409EA927 com params e Options1Array        
    // (                                                                                                                                                                                                
    //     [headers] => Array                                                                                                                                                                           
    //         (                                                                                                                                                                                        
    //             [content-type] => application/x-www-form-urlencoded                                                                                                                                  
    //             [Accept] => application/json                                                                                                                                                         
    //         )                                                                                                                                                                                        
                                                                                                                                                                                                     
    //     [form_params] =>                                                                                                                                                                             
    //     [verify] =>                                                                                                                                                                                  
    //     [body] => sessionId=a0a1cb06646b4b6bb8da7fe3c13f7785&amount=100.00&cardNumber=4111111111111111&cardBrand=visa&cardCvv=123&cardExpirationMonth=11&cardExpirationYear=2030                     
    // )                                                                                                                                                                                                
                                                                                                                                                                                                     
    // [2019-04-11 17:11:14] testing.INFO: Resposta: {"token":"5cedbf60f0744d45bb2eae8296fe5128"} 


    // [2019-04-11 17:13:10] testing.INFO: Fazendo requisição https://df.uol.com.br/v2/cards?email=pagseguro@passepague.com.br&token=7899389154E840EF8B442E60409EA927 com params e Options1Array        
    // (                                                                                                                                                                                                
    //     [headers] => Array                                                                                                                                                                           
    //         (                                                                                                                                                                                        
    //             [content-type] => application/x-www-form-urlencoded                                                                                                                                  
    //             [Accept] => application/json                                                                                                                                                         
    //         )                                                                                                                                                                                        
                                                                                                                                                                                                    
    //     [form_params] =>                                                                                                                                                                             
    //     [verify] =>                                                                                                                                                                                  
    //     [body] => sessionId=6e25b83fe0ca43618fef68cb8623fd4a&amount=100.00&cardNumber=4111111111111111&cardBrand=visa&cardCvv=123&cardExpirationMonth=11&cardExpirationYear=2030                     
    // )                                                                                                                                                                                                
                                                                                                                                                                                                    
    // [2019-04-11 17:13:10] testing.INFO: Resposta: <html><head><title>Request Rejected</title></head><body>The requested URL was rejected. Please consult with your administrator.<br><br>Your support
    // ID is: 10745133306914515030</body></html>  




    public function registerCreditCard(CreditCardToken $creditCardToken, $total = 0)
    {
        if (is_null($this->sessionId)) {
            $this->sessionId = $this->getSession();
        }

        try {
            $bandeira = 'visa';
            if (!empty($creditCardToken->creditCard->brand_name)) {
                $bandeira = $creditCardToken->creditCard->brand_name;
            }
    
            $params = [];
            $params['sessionId'] = $this->sessionId;
            $params['amount'] = number_format($total, 2, '.', '');
            $params['cardNumber'] = $creditCardToken->creditCard->card_number;
            $params['cardBrand'] = $bandeira;
            $params['cardCvv'] = $creditCardToken->creditCard->cvc;
            $params['cardExpirationMonth'] = $creditCardToken->creditCard->exp_month;
            $params['cardExpirationYear'] = '20'.$creditCardToken->creditCard->exp_year;
    
            // $result = $this->post( $params, true);
            $result = $this->postJson($this->getDfHost().'v2/cards?'.$this->getLoginParams(), $params);
            
            if (isset($result) && isset($result->token)) {
                Log::info('[Pagseguro] Cadastro Cartao'. print_r($result, true));
                $gatewayCreditCardParams = [
                    'token' => $result->token,
                    'gateway_id' => Pagseguro::$ID,
                    'credit_card_id' => $creditCardToken->creditCard->id
                ];
                if ($this->user) {
                    $gatewayCreditCardParams['user_id'] = $this->user->id;
                }
                GatewayCreditCard::firstOrCreate($gatewayCreditCardParams);
                return $result->token;
            }

            Log::info('[Pagseguro] Erro no cadastro do cartão '. print_r($params, true). print_r($result, true));
            return false;
        } catch (Exception $error) {
            // Caso ocorreu algum erro
            $this->error = $error->getMessage();
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
            Log::warning(
                '[Pagseguro] Cartão nao Passou!',
                [
                        'code' => $error->getMessage()
                   ]
            );
            return false;
        }

        $this->error = 'Cartão não autorizada';
        $this->errorCode = 0;
        $this->errorMessage = 'Não identificado';
        if (isset($orderGateway)) {
            Log::warning(
                '[Pagseguro] Cartão negada!',
                [
                        'code' => $orderGateway->getReturnCode()
                   ]
            );
        }
        return false;
    }

    private function obterParcelamento()
    {
        // GET https://pagseguro.uol.com.br/checkout/v2/installments.json?sessionId={{session_id}}& amount={{valor_sera_cobrado}}&creditCardBrand={{bandeira_do_cartao}}&maxInstallmentNoInterest={{quantidade_parcelas_sem_juros}}
        // Retorno
        //        {
        //    "error":false,
        //    "installments":{
        //       "mastercard":[
        //          {
        //             "quantity":1,
        //             "totalAmount":16.00,
        //             "installmentAmount":16.00,
        //             "interestFree":true
        //          },
        //          {
        //             "quantity":2,
        //             "totalAmount":16.72,
        //             "installmentAmount":8.36,
        //             "interestFree":false
        //          },
        //          {
        //             "quantity":3,
        //             "totalAmount":16.97,
        //             "installmentAmount":5.66,
        //             "interestFree":false
        //          }
        //       ]
        //    }
        // }
    }

    /**
     * Jamais Usaremos, Nunca Usaremos!
     */
    public function registerOrderUsingCheckoutRedirect(Order &$registerOrder)
    {
        try {
            $service = (new CheckoutService($this->_connection))->createCheckoutBuilder();
        
            foreach($registerOrder->itemOrders as $itemOrder) {
                $service = $service->addItem($this->fromItemOrderModel($itemOrder));
            }

            $checkout = $service->getCheckout();

            //Se você quer usar uma url de retorno
            $checkout->setRedirectTo("https://payment.passepague.com/".'?code=' . $registerOrder->tid);
            
            //Se você quer usar uma url de notificação
            $checkout->setNotificationURL("https://payment.passepague.com/".'?code=' . $registerOrder->tid);
            return true;
        } catch (Exception $error) { // Caso ocorreu algum erro
            $this->error = $error->getMessage();
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
            Log::warning(
                '[Pagseguro] Compra nao Passou!',
                [
                        'code' => $error->getMessage()
                   ]
            );
            return false;
        }

        $this->error = 'Compra não autorizada';
        $this->errorCode = 0;
        $this->errorMessage = 'Não identificado';
        if (isset($checkout)) {
            Log::warning(
                '[Pagseguro] Compra negada!',
                [
                        'code' => print_r($checkout, true)
                   ]
            );
        }
        return false;
    }

    /**
     * Filtra a mensagem que vem da rede
     */
    public function filterMessagemForClient($message, $code)
    {
        Log::notice('[Pagseguro] Compra negada por motivo nao mapeado: '.$message);

        return $message;
    }

    private function fromCustomerModel(Customer &$customer) :CustomerGateway
    {
        $phoneGateway = new PhoneGateway(
            $customer->areaCode,
            $customer->number
        );

        $addressGateway = new AddressGateway(
            $customer->state,
            $customer->city,
            $customer->postalCode,
            $customer->district,
            $customer->street,
            $customer->number,
            $customer->complement
        );
        
        return new CustomerGateway(
            $customer->email,
            $customer->name,
            $phoneGateway,
            $addressGateway
        );
    }

    /**
     * Estornar transação
     *  https://ws.pagseguro.uol.com.br/v2/transactions/refunds
     * &transactionCode={{transaction-code}}
     * &refundValue=100.00
     * required

     * transactionCode Código da transação
     * Transação deverá estar com os status Paga, Disponível ou Em disputa.
     * Formato: Uma sequência de 36 caracteres, com os hífens, ou 32 caracteres, sem os hífens
     * 
     * refundValue Valor do estorno.
     * Utilizado no estorno de uma transação, corresponde ao valor a ser devolvido. Se não for informado, o PagSeguro assume que o valor a ser estornado é o valor total da transação.
     * Formato: Decimal, com duas casas decimais separadas por ponto (p.e., 1234.56), maior que 0.00 e menor ou igual ao valor da transação.
     */
    public function refund()
    {

    }

    /**
     * curl -X GET \
     *    'https://ws.pagseguro.uol.com.br/v3/transactions/2504A4D645CD4EFCA3EA6DE8034FB945?email=email@email.com&token=token' \
     * https://ws.pagseguro.uol.com.br/v3/transactions/transactionCode
     */
    public function showOrder()
    {
        
    }

    /**
     * https://ws.pagseguro.uol.com.br/v2/transactions
     * &initialDate=2011-01-01T00:00
     * &finalDate=2011-01-28T00:00
     * &page=1
     * &maxPageResults=100
     */
    public function searchOrders()
    {

    }

    private function fromItemOrderModel(ItemOrder &$itemOrder) :ItemGateway
    {
        return new ItemGateway($itemOrder->quantity, $itemOrder->item->name, $itemOrder->price);
    }

    /**
     * Usando biblioteca que nao é mais usada
     * Deprecated
     */
    private function fromOrderModelDeprecated(Order &$order) :OrderGateway
    {
        $items = [];
        //        $items = new ItemCollectionGateway([
        //            new ItemGateway(
        //                $order->id,
        //                $order->description,
        //                $order->amount,
        //                $order->quantity,
        //                null, //$shippingCost =
        //                null //$weight =
        //            )
        //        ]);
        $detailsGateway = new DetailsGateway(
            0, //$code
            $order->code->tid,
            0, //status
            Carbon::now(), // Data da Compra
            $order->deliveryDate, // Data Do evento
            $this->fromCustomerModel($order->customer)
        );
        $paymentMethodGateway = new PaymentMethodGateway(
            0, //Type
            0 //Code
        );

        $paymentGateway = new PaymentGateway(
            $paymentMethodGateway,
            0, //grossAmount
            0, //discountAmount
            $order->tax_payment_system,
            ($order->total-$order->tax_payment_system),
            0, //extraAmount
            $order->installments,
            $order->deliveryDate
        );

        // @todo Não precisa ainda
        // $shippingGateway = new ShippingGateway(
        //     $state,
        //     $city,
        //     $postalCode,
        //     $district,
        //     $street,
        //     $number,
        //     $complement
        // );

        /**
         * Inteiro
         *
         * @todo Não sei oq é
         */
        $type = 1;
        
        return new OrderGateway(
            $detailsGateway,
            $paymentGateway,
            $type,
            $items,
            null //$shippingGateway
        );
    }


    private function fromOrderModel(Order &$registerOrder, $creditCardToken = false)
    {
        $taxaEntrega = 0;
        if ($registerOrder->payment_type_id == PaymentType::$CREDIT_CARD_ID) {
            $params = $this->returnCreditCardOrderParams($registerOrder, $creditCardToken);
        } else if ($registerOrder->payment_type_id == PaymentType::$BOLETO_ID) {
            $params = $this->returnBoletoOrderParams($registerOrder);
        } else if ($registerOrder->payment_type_id == PaymentType::$SIMPLE_TRANSFER_ID) {
            $params = $this->returnDebitoOnlineParams($registerOrder);
        }

        // Dados do Pedido
        $params['paymentMode'] = 'default';
        if (isset($registerOrder->fingerprint_pagseguro) && !empty($registerOrder->fingerprint_pagseguro)) {
            $params['senderHash'] = $registerOrder->fingerprint_pagseguro;
        }
        $params['currency'] = 'BRL';
        // $params['extraAmount'] = (int) (0*100);
        $params['notificationURL'] = 'https://payment.passepague.com/services/orders/'.$registerOrder->tid;
        $params['reference'] = $registerOrder->tid;

        $params['installmentQuantity'] = $registerOrder->getInstallments();
        $params['installmentValue'] = number_format($registerOrder->total+$taxaEntrega, 2, '.', '');
        if (isset($registerOrder->installments) && ((int)$registerOrder->installments)>0) {
            $params['installmentQuantity'] = (int) $registerOrder->installments;
            $params['installmentValue'] = $registerOrder->valueForEachInstallment();
            $taxaEntrega = $taxaEntrega + (($params['installmentValue']*$params['installmentQuantity']) - $registerOrder->total);
        }

        // Dados do Receiver
        $params['receiverEmail'] = $registerOrder->customer->email;
        if (isset($this->user) && isset($this->user->gateway_pagseguro_public) && !empty($this->user->gateway_pagseguro_public)) {
            $params['receiverEmail'] = $this->user->gateway_pagseguro_public;
        }


        // Dados dos Itens
        $params['itemId1'] = '0001';
        $params['itemDescription1'] = 'Festa da Passepague';
        $params['itemAmount1'] = number_format($registerOrder->total, 2, '.', '');
        $params['itemQuantity1'] = 1;
        // $params['itemId2'] = '0002';
        // $params['itemDescription2'] = 'Notebook Rosa';
        // $params['itemAmount2'] = '25600.00';
        // $params['itemQuantity2'] = '2';

        // Localização de Evento/Produto
        // @todo verificar se o nome esta completo. nome e sobrenome
        $params['senderName'] = $registerOrder->customer->name;
        $params['senderCPF'] = $registerOrder->customer->cpf;
        // Todo
        $params['senderAreaCode'] = '21';
        $params['senderPhone'] = '999193898';

        if ($phone = $registerOrder->customer->phones()->orderBy('id', 'DESC')->first()) {
            $params['senderAreaCode'] = $phone->region;
            $params['senderPhone'] = $phone->number;
        }

        $params['senderIp'] = $registerOrder->getIp();
        if ($this->isProduction()) {
            $params['senderEmail'] = $registerOrder->customer->email;
        } else {
            $params['senderEmail'] = $registerOrder->customer->cpf.'@sandbox.pagseguro.com.br';
        }

        // Address Params
        $params['shippingAddressStreet'] = 'Av. Brig. Faria Lima';
        $params['shippingAddressNumber'] = '1384';
        $params['shippingAddressComplement'] = '5o andar';
        $params['shippingAddressDistrict'] = 'Jardim Paulistano';
        $params['shippingAddressPostalCode'] = '01452002';
        $params['shippingAddressCity'] = 'Sao Paulo';
        $params['shippingAddressState'] = 'SP';
        $params['shippingAddressCountry'] = 'BRA';
        $params['shippingType'] = '1';
        $params['shippingCost'] = $registerOrder->getFinalPaymentTaxe();
        $params['billingAddressStreet'] = 'Av. Brig. Faria Lima';
        $params['billingAddressNumber'] = '1384';
        $params['billingAddressComplement'] = '5o andar';
        $params['billingAddressDistrict'] = 'Jardim Paulistano';
        $params['billingAddressPostalCode'] = '01452002';
        $params['billingAddressCity'] = 'Sao Paulo';
        $params['billingAddressState'] = 'SP';
        $params['billingAddressCountry'] = 'BRA';
        if ($address = $registerOrder->customer->addresses()->orderBy('id', 'DESC')->first()) {
            $params['shippingAddressStreet'] = $address->street;
            $params['shippingAddressNumber'] = $address->number;
            $params['shippingAddressComplement'] = $address->complement;
            $params['shippingAddressPostalCode'] = $address->zipcode;
            $params['shippingAddressCity'] = $address->city;
            $params['shippingAddressState'] = $address->state;
            $params['shippingAddressCountry'] = $address->country;
            $params['billingAddressStreet'] = $address->street;
            $params['billingAddressNumber'] = $address->number;
            $params['billingAddressComplement'] = $address->complement;
            $params['billingAddressPostalCode'] = $address->zipcode;
            $params['billingAddressCity'] = $address->city;
            $params['billingAddressState'] = $address->state;
            $params['billingAddressCountry'] = $address->country;
            if (isset($address->neighborhood) && !empty($address->neighborhood)) {
                $params['shippingAddressDistrict'] = $address->neighborhood;
                $params['billingAddressDistrict'] = $address->neighborhood;
            }
        }
        
        return $this->postXml(
            $this->getWsHost().'v2/transactions?'.$this->getLoginParams(),
            $params
        );
    }

    private function returnCreditCardOrderParams(Order &$registerOrder, $creditCardToken = false)
    {
        $params = [];
        $params['paymentMethod'] = 'creditCard';
        if ($creditCardToken!==false) {
            $params['creditCardToken'] = $creditCardToken;
        } else {
            $params['creditCardToken'] = $registerOrder->creditCardToken->token;
        }
        $params['creditCardHolderName'] = $registerOrder->creditCardToken->creditCard->card_name;

        if ($registerOrder->creditCardToken->creditCard->holder) {
            if (!empty($registerOrder->cpf)) {
                $params['creditCardHolderCPF'] = $registerOrder->cpf; 
            }
            if (!empty($registerOrder->birth_date)) {
                $params['creditCardHolderBirthDate'] = $registerOrder->birth_date->format('d/m/Y');
            } else {
                $params['creditCardHolderBirthDate'] = '1991-08-1991';
            }
            if ($phone = $registerOrder->creditCardToken->creditCard->holder->phones()->orderBy('id', 'DESC')->first()) {
                $params['creditCardHolderAreaCode'] = $phone->region;
                $params['creditCardHolderPhone'] = $phone->number;
            }
        }

        if (isset($registerOrder->creditCardToken->creditCard->cpf) && !empty($registerOrder->creditCardToken->creditCard->cpf)) {
            $params['creditCardHolderCPF'] = $registerOrder->creditCardToken->creditCard->cpf; 
        }
        if (isset($registerOrder->creditCardToken->creditCard->birth_date) && !empty($registerOrder->creditCardToken->creditCard->birth_date)) {
            $params['creditCardHolderBirthDate'] = $registerOrder->creditCardToken->creditCard->birth_date->format('d/m/Y'); //'27/10/1987';
        }
        if (isset($registerOrder->creditCardToken->creditCard->phone) && !empty($registerOrder->creditCardToken->creditCard->phone)) {
            $phoneBreak = \Validate\Phone::break($registerOrder->creditCardToken->creditCard->phone_country.$registerOrder->creditCardToken->creditCard->phone_area_code.$registerOrder->creditCardToken->creditCard->phone);
            $params['creditCardHolderAreaCode'] = $phoneBreak['region']; //'11';
            $params['creditCardHolderPhone'] = $phoneBreak['number']; //'56273440';
        }
        return $params;
    }

    private function returnBoletoOrderParams(Order &$registerOrder)
    {
        $params = [];
        $params['paymentMethod'] = 'boleto';
        return $params;
    }

    private function returnDebitoOnlineParams(Order &$registerOrder)
    {
        $params = [];
        $params['paymentMethod'] = 'eft';
        $params['bankName'] = 'itau';
        return $params;
    }

    /**
     * Avisa ao antifraude que o pedido foi alterado
     */
    public function orderIsChanged(Order $registerOrder)
    {
        try {
            $result = $this->postXml($this->getWsHost().'v2/transactions?'.$this->getLoginParams().'&reference='.$registerOrder->tid);
            Log::info('[Payment] OrderIsChanged - Retornando REsultados da Pagseguro [1]! '.print_r($result, true));
            Log::info('[Payment] OrderIsChanged - Retornando REsultados da Pagseguro [2]! '.print_r($result->transactions, true));
            Log::info('[Payment] OrderIsChanged - Retornando REsultados da Pagseguro [3]! '.print_r($result->transactions->transaction[0], true));
            
            $codeStatus = false;
            if ($result->transactions->transaction[0]) {
                $codeStatus = $result->transactions->transaction[0];
            }

            /**
             *  WAITING_PAYMENT = '1';o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
             *  UNDER_ANALYSIS = '2';o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
             *  PAID = '3'; a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
             *  AVAILABLE = '4';a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
             *  UNDER_CONTEST = '5';  o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
             *  RETURNED = '6'; o valor da transação foi devolvido para o comprador.
             *  CANCELLED = '7'; a transação foi cancelada sem ter sido finalizada.
             *  Debitado = '8'; o valor da transação foi devolvido para o comprador.
             *  Retenção temporária: = '9'; o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
             */
            if (!$codeStatus) {
                return false;
            }
            // Caso Exista Código do Pedido
            if (isset($orderGateway->paymentLink) && !empty($orderGateway->paymentLink)) {
                $registerOrder->payment_link = (string) $orderGateway->paymentLink;
            }
            // Tratando Status
            if ((string) $codeStatus == '3' && $registerOrder->status != Order::$STATUS_APPROVED) {
                $registerOrder->status = Order::$STATUS_APPROVED;
                Log::info('[Pagseguro Pedido] Transação Atualizada: '.$registerOrder->status.' Tid: '. $orderGateway->code);
                return true;
            }
            
            if ((string) $codeStatus == '2' && $registerOrder->status != Order::$STATUS_ANALYSIS) {
                $registerOrder->status = Order::$STATUS_ANALYSIS;
                Log::info('[Pagseguro Pedido] Transação Atualizada: '.$registerOrder->status.' Tid: '. $orderGateway->code);
                return true;
            }
            
            if ((string) $codeStatus == '1' && $registerOrder->status != Order::$STATUS_PEDDING_PAYMENT) {
                $registerOrder->status = Order::$STATUS_PEDDING_PAYMENT;
                Log::info('[Pagseguro Pedido] Transação Atualizada: '.$registerOrder->status.' Tid: '. $orderGateway->code);
                return true;
            }
            
            if (((string) $codeStatus == '5' || (string) $codeStatus == '6' || (string) $codeStatus == '8' || (string) $codeStatus == '9') && $registerOrder->status != Order::$STATUS_FRAUD_WITH_LOSS) {
                $registerOrder->status = Order::$STATUS_FRAUD_WITH_LOSS;
                Log::info('[Pagseguro Pedido] Transação Atualizada: '.$registerOrder->status.' Tid: '. $orderGateway->code);
                return true;
            }
            
            if (((string) $codeStatus == '7') && $registerOrder->status != Order::$STATUS_REPROVED) {
                $registerOrder->status = Order::$STATUS_REPROVED;
                Log::info('[Pagseguro Pedido] Transação Atualizada: '.$registerOrder->status.' Tid: '. $orderGateway->code);
                return true;
            }
            return false;
        } catch (Exception $error) {
            // Caso ocorreu algum erro
            // $xml = new SimpleXMLElement($error->getMessage());
            if ($this->isValidXml($error->getMessage())) {
                Log::info(
                    'Erro em XMl:', [
                    'erro' => $error->getMessage(),
                    $this->xmlDeserialize($error->getMessage())
                    ]
                );
            } else {
                Log::info(
                    'SemXMl', [
                    'erro' => $error->getMessage(),
                    'error' => $error
                    ]
                );
            }
            return false;
        }
        return false;
    }

    /**
     * Avisa ao antifraude que o pedido foi alterado
     */
    public function changedOrder(Order $registerOrder)
    {
        return true;
    }
}