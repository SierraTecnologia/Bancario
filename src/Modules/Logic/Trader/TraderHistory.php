<?php
// https://medium.com/coinmonks/how-to-generate-a-bitcoin-address-step-by-step-9d7fcbf1ad0b

namespace Bancario\Modules\Logic\Trader;

class TraderHistory
{

    protected $argumentQntCandles = 6;
    protected $argumentCandleSize = '15m';

    public function __construct($argumentQntCandles = 6, $argumentCandleSize = '15m', $api = false)
    {
        $this->argumentQntCandles = $argumentQntCandles;
        $this->argumentCandleSize = $argumentCandleSize;

        if (!$this->api = $api) {
            $this->api = \Bancario\Models\Tradding\ExchangeAccount::first();
        }
    }

    public function calcular()
    {
        
        /**
         * Pega os Candles da Binance
         */
        $ticks = $this->api->getCandlesticks("BTCUSDT", $this->argumentCandleSize);

        /**
         * Calcula Média
         */
        $i = 0;
        $total = 0;
        while($i<$this->argumentQntCandles) {
            ++$i;
            $candle = array_pop($ticks);
            $total += $candle['close'];
        }

        /**
         * Retorna Media Movel
         */
        return $total/$i;
    }
}
