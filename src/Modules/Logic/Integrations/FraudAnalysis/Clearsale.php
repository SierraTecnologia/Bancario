<?php

/**
 * Documentação
 * http://docs.Clearsale.com/pt/#enviar-um-pedido/

 *  Acompanharei a integração da loja PassePague com a ClearSale. 
 *  Abaixo os dados de homologação:

 *  Login: PassePague
 *  Senha: y4C2KlGjMV

 *  Fingerprint (seu_app): b16hhpwaci5tvx33akee

 *  Endponit de homologação: https://homologacao.clearsale.com.br/api/

 *  Abaixo os links com os manuais necessários para a integração:

 *  Introdução: https://api.clearsale.com.br/docs/how-to-start

 *  Manual de integração da API: https://api.clearsale.com.br/docs/tickets

 *  Fingerprint: https://api.clearsale.com.br/docs/finger-print

 *  Mapper: https://api.clearsale.com.br/docs/mapper

 *  Para fins de testes foram criadas as regras abaixo:

 *  IMPORTANTE: Para que as regras abaixo funcionem corretamente é necessário que enviem os pedidos com a data do evento com diferença de no mínimo 24 horas a mais à partir da data de envio dos pedidos para análise da ClearSale. Durante o processo de homologação haverá necessidade de testarmos todos os cenários abaixo.

 *  *   Para aprovação automática, os pedidos devem ser enviados com valor total menor ou igual a R$ 200,00;
 *  *   Para análise manual, os pedidos devem ser enviados com valor total entre R$201,00 e R$300,00;
 *  *   Para reprovação automática os pedidos devem ser enviados com valor total maior que R$300,00.


 *  Qualquer dúvida estamos a disposição.

 *  Atenciosamente.
 *  Marcos Nolasco
 *  Integrações
 *  +55 11 3728-8788 R. 1332
 *  marcos.nolasco@clear.sale
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
use Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale\Authentication as ClearSaleAuthentication;
use ClearSale\ClearSaleAnalysis;
use ClearSale\XmlEntity\SendOrder\Order as ClearSaleOrder;
use ClearSale\Environment\Sandbox;
use ClearSale\Environment\Production;
use Exception;
use Carbon\Carbon;

class Clearsale extends FraudAnalysis
{
    public static $ID = 2;
    public static $NAME = 'Clearsale';

    protected function getConnection($business)
    {
        return true;
        // $clearsaleKey = $business->frauds_clearsale_secret;
        $clearsaleKey = (new ClearSaleAuthentication(
            config('gateway.clearsale.user'),
            config('gateway.clearsale.password')
        ))->token;
        if ($this->isProduction()) {
            return new ClearSaleAnalysis(new Production($clearsaleKey));
        }
        return new ClearSaleAnalysis(new Sandbox($clearsaleKey));
    }

    public function registerCustomer(CustomerToken &$customer)
    {
        Log::debug('Clearsale -> Anti Fraude Customer');
        return true;
    }

    public function registerCreditCard(CreditCardToken &$creditCard)
    {
        Log::debug('Clearsale -> Anti Fraude Cartão de Crédito');
        return true;
    }

    public function registerOrder(Order &$registerOrder)
    {
        return true;
        Log::debug('Clearsale -> Anti Fraude Pedido');

        // // @Terminar
        try {

            $items = $registerOrder->itemOrders;
            if (isset($_GET['fraud_analysis']['cart']['items'])) {
                $items = $_GET['fraud_analysis']['cart']['items'];
            }

            $order = new ClearSaleOrder();
            $order->setFingerPrint('b16hhpwaci5tvx33akee')
                ->setId($registerOrder->id)
                ->setDate(Carbon::now())
                ->setEmail($registerOrder->customer->email)
                ->setTotalItems($registerOrder->itemOrders->count())
                ->setTotalOrder($registerOrder->total)
                ->setQuantityInstallments($registerOrder->installments)
                ->setIp($registerOrder->getIp())
                ->setOrigin($registerOrder->origin)
                ->setBillingData($registerOrder->customer)
                ->setShippingData($registerOrder->customer)
                ->setItems($items)
                ->setPayments($registerOrder->getPaymentType());
        
            // Solicitação e Resultado da análise
            switch ($this->_connection->analysis($order))
            {
            case ClearSaleAnalysis::APROVADO:
                // Análise aprovou a cobrança, realizar o pagamento
                $this->_status = 1;
                return true;
                    break;
            case ClearSaleAnalysis::REPROVADO:
                // Análise não aprovou a cobrança
                $this->_status = 2;
                return false;
                    break;
            case ClearSaleAnalysis::AGUARDANDO_APROVACAO:
                // Análise pendente de aprovação manual
                $this->_status = 0;
                return true;
                    break;
            }
        } catch (Exception $e) {
            // Erro genérico da análise
            $this->_status = 0;
            return true;
        }

        $this->_status = 0;
        return true;
    }
}