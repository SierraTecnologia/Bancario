<?php

namespace Bancario\Modules\Logic\Integrations\Gateways;

use Bancario\Modules\Logic\Integrations\Gateways;
use App\Models\Identitys\CustomerToken;
use Bancario\Models\Banks\CreditCardToken;
use App\Models\Shopping\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Rede\Exception\RedeException;

/**
 * Classe Responsável pelo E-rede
 * Url: https://www.userede.com.br/desenvolvedores/pt/produto/e-Rede#tutorial
 */
class Erede extends Gateways
{
    public static $ID = 2;

    public static $NAME = 'Erede';

    protected function getConnection(User $business)
    {
        Log::debug('[Erede] Se conectando com pv-'. $business->gateway_erede_public. '- E key: -'. $business->gateway_erede_secret.'-');
        return new \Rede\Store($business->gateway_erede_public, $business->gateway_erede_secret);
    }

    protected function getEnvironment()
    {
        if (config('gateway.erede.pv')=='production') {
            return \Rede\Environment::production();
        }
        $environment = \Rede\Environment::sandbox();
        // $environment->setIp('127.0.0.1');
        // $environment->setSessionId('NomeEstabelecimento-WebSessionID');
        return $environment;
    }

    public function isErrorByInsufficientFunds()
    {
        if ($this->errorCode == 111) {
            return true;
        }
        return false;
    }

    public function canBeFraud()
    {
        return false;
    }

    public function registerCustomer(CustomerToken &$customer)
    {
        return true;
    }

    public function registerCreditCard(CreditCardToken &$creditCard)
    {
        return true;
    }

    public function registerOrder(Order &$registerOrder)
    {
        if (empty($registerOrder->creditCard)) {
            Log::warning('[Erede] Problema interno! Cartão de crédito não mencionado');
            return false;
        }

        Log::debug(
            'Relizando pedido de '.$registerOrder->total.' reais.'.
            '... usando cartão '.$registerOrder->creditCard->card_number.
            ' - Cvv: [Filtrado] - Mes: '.
            $registerOrder->creditCard->exp_month.' - Ano: '.
            $registerOrder->creditCard->exp_year.' - Nome: '.
            $registerOrder->creditCard->card_name
        );
        
        try {
            // Transação que será autorizada
            $dataTransaction = (new \Rede\Transaction($registerOrder->total, 'pedido' . time()))->creditCard(
                $registerOrder->creditCard->card_number,
                $registerOrder->creditCard->cvc,
                $registerOrder->creditCard->exp_month,
                $registerOrder->creditCard->exp_year,
                $registerOrder->creditCard->card_name
            );
            if (isset($registerOrder->installments) 
                && !empty($registerOrder->installments) 
                && ((int) $registerOrder->installments) > 1
            ) {
                $dataTransaction->setInstallments((int) $registerOrder->installments);
            }

            // Autoriza a transação
            $transaction = (new \Rede\eRede($this->_connection))->create(
                $dataTransaction
            );

            if ($transaction->getReturnCode() == '00') {
                Log::info('[Compra] Transação Autorizada com sucesso! Valor: '.$registerOrder->total.' Tid: '. $transaction->getTid());
                $registerOrder->gateway_id = self::$ID;
                $registerOrder->gateway_token_rede = $transaction->getTid();
                $registerOrder->status = Order::$STATUS_APPROVED;
                return true;
            }
        }
        catch( RedeException $e) {
            $this->error = $this->filterMessagemForClient($e->getMessage(), $e->getCode());
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();
            return false;
        }
        
        $this->error = 'Compra não autorizada';
        $this->errorCode = $transaction->getReturnCode();
        $this->errorMessage = 'Não identificado';
        Log::warning(
            '[Erede] Compra negada pela rede!',
            [
                'code' => $transaction->getReturnCode()
            ]
        );
        return false;
    }

    /**
     * Filtra a mensagem que vem da rede
     * Url: https://www.userede.com.br/desenvolvedores/pt/produto/e-Rede#tutorial
     *
     * ExpirationYear: Invalid parameter size. 1
     * ExpirationYear: Invalid parameter format 2
     * securityCode: Invalid parameter size 15
     * securityCode: Invalid parameter format 16
     * CardNumber: Invalid parameter size. 36
     * CardNumber: Invalid parameter format. 37
     * cardNumber: Required parameter missing. 38
     * Product or service disabled for this merchant. Contact Rede 51
     * cardHolderName: Invalid parameter size 55
     * Error in reported data. Try again. 56
     * Transaction not allowed for this product or service 69
     * Expired card. Transaction cannot be resubmitted. Contact issuer. 79
     * Expired card.86
     * Unauthorized. Restricted card. 105
     * Unauthorized. Please try again. 107
     * Unauthorized. Nonexistent card. 109
     * Unauthorized. Transaction type not allowed for this card. 110
     * Unauthorized. Insufficient funds. 111
     * Unauthorized. Expiry date expired. 112
     * Unauthorized. Invalid security code. 119
     * Zero dollar transaction approved successfully. 120
     * Error processing. Please try again 121
     * Transaction previously sent 122
     * Unauthorized. Bearer requested the end of the recurrences in the issuer. 123
     * Unauthorized. Contact Rede 124
     * Timeout. Try again 150
     * installments: Greater than allowed 151
     * documentNumber: Invalid number 153
     */
    public function filterMessagemForClient($message, $code)
    {
        if ($code==1 || $code==2) {
            return 'Ano de expiração do cartão inválido!';
        }

        if ($code==15 || $code==16 || $code==119) {
            return 'Cvv do cartão inválido, confira por favor!';
        }

        if ($code==36 || $code==37 || $code==38) {
            return 'Número do cartão inválido, verifique por favor!';
        }

        if ($code==51) {
            return 'Cartão não autorizado!';
        }

        if ($code==55) {
            return 'Verifique o nome do proprietário do cartão, por favor!';
        }

        if ($code==56) {
            return 'Verifique os dados do cartão!';
        }

        if ($code==69) {
            return 'Por favor use outra bandeira de cartão!';
        }

        if ($code==79 || $code==89 || $code==112) {
            return 'Esse cartão está expirado, use outro por favor!';
        }

        if ($code==105) {
            return 'Dados de cartão inválido!';
        }

        if ($code==105) {
            return 'Cartão não autorizado!';
        }

        if ($code==107) {
            return 'Não autorizado, tente novamente!';
        }

        if ($code==109) {
            return 'Cartão não existe!';
        }

        if ($code==110) {
            return 'Cartão não autorizado!';
        }

        if ($code==111) {
            return 'Cartão sem saldo!';
        }

        Log::notice('[Erede] Compra negada pela rede por motivo nao mapeado: '.$message.$code);

        return $message;
    }
}