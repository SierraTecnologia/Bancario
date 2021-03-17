<?php
/**
 * Consulta api da CoinMarketCap.com para saber o valor de conversao de moedas
 */

namespace Bancario\Util\Integrations\Fonts;

use App\Logic\Integrations\Integration;
use App\Models\Identitys\Customer;
use Bancario\Models\Banks\CreditCard;
use App\Models\Shopping\Order;
use App\Models\User;
use Bancario\Models\Money\Money;
use Illuminate\Support\Facades\Log;

/**
 * Classe Responsável pelo cielo
 *
 * @todo Fazer
 */
class CoinMarketCap extends Integration
{
    /**
     * Id da Fonte de Consulta de Preço de Conversão de moedas
     */
    public static $id = 1;
    public static $name = 'Coin Market Cap';
    public static $url = '';

    public function diffByMoneysPrice(Money $toBuy, Money $toSend)
    {
        return true;
    }
}