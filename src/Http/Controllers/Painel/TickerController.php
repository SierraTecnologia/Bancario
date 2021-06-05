<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Ticker;
use Bancario\Models\Jesse\Ticker as JesseTicker;
use Bancario\Models\Jesse\Candle as JesseCandle;
use Bancario\Modules\Graph\Resources\CandleRepository;
use Pedreiro\CrudController;
use Bancario\Models\Tradding\Exchange;
use Request;

class TickerController extends Controller
{
    use CrudController;

    public function __construct(Ticker $model, CandleRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
        parent::__construct();
    }

    public function chatdisplay(Request $request)
    {
        $candleRepository = $this->repository;
dd($candleRepository);
        return view('bancario::components.candlestick', 
            compact(
                'candleRepository',
            )
        );
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
