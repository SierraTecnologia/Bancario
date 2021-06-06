<?php
// @todo Refazer
// https://medium.com/coinmonks/how-to-generate-a-bitcoin-address-step-by-step-9d7fcbf1ad0b

namespace Bancario\Modules\Logic\Indicator;

class MediaMovel
{

    /**
     * Arg. p/ Quantidade de Velas usadas no calculo
     */
    protected $argumentQntCandles = 6;

    /**
     * Arg. p/ Tamanho da Vela
     */
    protected $argumentCandleSize = '15m';

    /**
     * Usado para conectar na binance
     */
    protected $api = false;

    /**
     * @param argumentQntCandles Arg. p/ Quantidade de Velas usadas no calculo
     * @param argumentCandleSize Arg. p/ Tamanho da Vela
     * @param api Usado para conectar na binance
     */
    public function __construct(
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
