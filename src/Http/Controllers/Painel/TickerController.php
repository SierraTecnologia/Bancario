<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Ticker;
use Bancario\Models\Jesse\Ticker as JesseTicker;
use Bancario\Models\Jesse\Candle as JesseCandle;
use Pedreiro\CrudController;

class TickerController extends Controller
{
    use CrudController;

    public function __construct(Ticker $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function chatdisplay()
    {
        // Params
        $quantityCandles = 1 * 60 * 24; // * 7;
        $exchangeCode = 'Binance';
        $symbol = 'BTC-USDT';
        // $period = '15m';

        // Algoritmo
        $tickets = JesseCandle::inExchange($exchangeCode)->forPair($symbol)
        // ->where('period', $period)
        ->orderByDesc('timestamp')
        ->limit($quantityCandles)
        ->get();
        
        $tickets = $tickets->map(function ($tick) {
            return '{
                x: new Date('.$tick->timestamp.'),
                y: ['.$tick->open.', '.$tick->high.', '.$tick->low.', '.$tick->close.']
              }';
        });
        return view('components.candlestick', compact('tickets'));
    }

    // public function chatdisplay()
    // {
    //     $exchangeId = 6;
    //     $symbol = 'BTCUSDT';
    //     $period = '15m';
    //     $tickets = $this->model::where('exchange_code', $exchangeId)->where('symbol', $symbol)->where('period', $period)->get();
    //     $tickets = $tickets->map(function ($tick) {
    //         return '{
    //             x: new Date('.$tick->close_time.'),
    //             y: ['.$tick->open.', '.$tick->high.', '.$tick->low.', '.$tick->close.']
    //           }';
    //     });
    //     return view('components.candlestick', compact('tickets'));
    // }
}
