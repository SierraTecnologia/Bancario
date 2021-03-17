<?php
/**
 * Consulta api da CoinMarketCap.com para saber o valor de conversao de moedas
 * 
 * 20190320 - Diferença de um pouco menos de 1% a menos que o coinmarketcap
 */

namespace Bancario\Util\Integrations\Fonts;

use App\Logic\Integrations\Integration;
use Bancario\Models\Money\Money;
use App\Models\User;
use Bancario\Models\Money\MoneyConversionPrice;
use Illuminate\Support\Facades\Log;

/**
 * Classe Responsável pelo cielo
 *
 * @todo Fazer
 */
class Cryptonator extends Integration
{
    /**
     * Id da Fonte de Consulta de Preço de Conversão de moedas
     */
    public static $id = 2;
    public static $name = 'Cryptonator';
    public static $url = 'https://api.cryptonator.com/api/';

    protected function getConnection(User $business)
    {
        return $this;
    }

    /**
     * Result: {
     *   "ticker": {
     *     "base":"BTC",
     *     "target":"USD",
     *     "price":"4009.97424167",
     *     "volume":"37978.51787799",
     *     "change":"-1.31410174"
     *   },
     *   "timestamp":1553058062,
     *   "success":true,
     *   "error":""
     * }
     */
    public function diffByMoneysPrice(Money $base, Money $target)
    {
        // Ex: ticker/btc-brl
        $path = 'ticker/'.$base->symbol.'-'.$target->symbol;
        $result = $this->get($path);
        MoneyConversionPrice::create(
            [
            'money_base_id' => $base->id,
            'money_target_id' => $base->id,
            'font_id' => 2,
            'price' => $result->ticker->timestamp,
            'change' => $result->ticker->change,
            'volume' => $result->ticker->volume,
            'time_search' => $result->ticker->timestamp,
            'date' => date('Ymd', $result->ticker->timestamp)
            ]
        );

        return $result->ticker->price;
    }
}