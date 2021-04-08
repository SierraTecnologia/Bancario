<?php

namespace Bancario\Modules\Indicators\Base;

class MediaMovelIndicator
{

    /**
     * Parametros Obrigatórios
     */
    protected $requeriments = [
        'pair_code',
        'exchange_code',
        'period' // Padrao de 1 Minuto,
    ];

    /**
     * Parametros Obrigatórios
     */
    protected $params = [
        'only_last_days',
    ];

    public function calculeForTime(
        $argumentQntCandles = 6,
        $argumentCandleSize = '1m',
        $api = false
    ) {
        $this->argumentQntCandles = $argumentQntCandles;
        $this->argumentCandleSize = $argumentCandleSize;

        if (!$this->api = $api) {
            $this->api = \Bancario\Models\Tradding\ExchangeAccount::first();
        }
    }







    // $api = new \Binance\API(
    //     "afLPF8tuJozZFCnIYd7XMsMoS24jGh26W6kDfb2Gda6qxPjRO1np99hTmGOX733B",
    //     "XQBQAh59fUQNW7inxw7np9tWO6GelnNo9n9qqYp3mPb2Uop9phHrGvN0OJchwIGH"
    // );
    // // $api->price("BNBBTC");

    // $api->candlesticks("BTCUSDT");













    /**
     * Cacular
     */
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
