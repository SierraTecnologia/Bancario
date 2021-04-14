<?php

namespace Bancario\Console\Commands;

use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\User;
use Bancario\Models\Jesse\Candle;

class SystemExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repo = app(\Bancario\Modules\Graph\Resources\CandleRepository::class);
        dd(
            $repo->getRecentData()
        );
        // Load users
        $candles = Candle::all();

        // Export all candles
        (new FastExcel($candles))->export('candles.xlsx');


        // // Export consumes only a few MB, even with 10M+ rows.
        // (new FastExcel(
        //     function () {
        //         foreach (Candle::cursor() as $candle) {
        //             yield $candle;
        //         }
        //     }
        // ))->export('candle.xlsx');
    }

    

}
