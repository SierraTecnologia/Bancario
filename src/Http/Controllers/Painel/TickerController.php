<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Ticker;
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
        $exchangeId = 6;
        $symbol = 'BTCUSDT';
        $period = '15m';
        $tickets = $this->model::where('exchange_code', $exchangeId)->where('symbol', $symbol)->where('period', $period)->get();
        $tickets = $tickets->map(function ($tick) {
            return '{
                x: new Date('.$tick->close_time.'),
                y: ['.$tick->open.', '.$tick->high.', '.$tick->low.', '.$tick->close.']
              }';
        });
        return view('components.candlestick', compact('tickets'));
    }
}
