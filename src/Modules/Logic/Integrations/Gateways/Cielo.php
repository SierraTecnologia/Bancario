<?php

namespace Bancario\Modules\Logic\Integrations\Gateways;

use Bancario\Modules\Logic\Integrations\Gateways;
use App\Models\Identitys\CustomerToken;
use Bancario\Models\Banks\CreditCardToken;
use App\Models\Shopping\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Classe Responsável pelo cielo
 *
 * @todo Fazer
 */
class Cielo extends Gateways
{
    public static $ID = 4;
    public static $NAME = 'Cielo';

    protected function getConnection(User $business)
    {
        Log::debug('[Cielo] Se conectando com pv-'. $business->gateway_cielo_public. '- E key: -'. $business->gateway_cielo_secret.'-');
        return new \Rede\Store($business->gateway_cielo_public, $business->gateway_cielo_secret);
    }

    public function isErrorByInsufficientFunds()
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
            Log::warning('[Cielo] Problema interno! Cartão de crédito não mencionado');
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

        // @todo Fazer Cielo
        Log::warning(
            '[Cielo] Ainda precisa fazer essa bagaça!'
        );

        $transaction = false; //@todo
        
        
        
        $this->error = 'Compra não autorizada';
        Log::warning(
            '[Cielo] Compra negada!',
            [
                'code' => $transaction->getReturnCode()
            ]
        );
        return false;
    }

    /**
     * Filtra a mensagem que vem da rede
     */
    public function filterMessagemForClient($message, $code)
    {

        Log::notice('[Cielo] Compra negada pela rede por motivo nao mapeado: '.$message);

        return $message;
    }
}