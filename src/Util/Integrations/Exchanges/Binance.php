<?php
// this is taken from https://github.com/coinables/Binance-API-PHP/blob/features/finex.php
// 
// TODO redo this and write a proper wrapper.
// I am mostly including this as an API KEY verification, however this can be used for creating a
// bot within this system.
// 

namespace Bancario\Util\Integrations\Exchanges;

/**
 * Class Binance
 *
 * @package Bancario\Util\Integrations\Exchanges
 *
 *              Streaming is a different animal and done via the command.
 */
class Binance
{
    public $api;

    public function __construct($apikey, $secret)
    {
        $this->api = new \Binance\API(
            $apikey,
            $secret
        );;
    }

    public function getBalances()
    {
        return $this->api->balances();
    }

    public function getPrice($symbol)
    {
        return $this->api->price($symbol);
    }

    public function getCandlesticks($symbol, $candleSize)
    {
        return $this->api->candlesticks($symbol, $candleSize);
    }
}

?>

