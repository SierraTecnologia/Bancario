<?php

namespace Bancario\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Bancario\Models\Jesse\Candle;
use Carbon\Carbon;


class GraphUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:update';

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
        // Update Indicadores
        // $builderMetrics = new \Bancario\Modules\Graph\Builders\GraphMetricsBuilder();
        // $builderMetrics->build();

        // Update OpenAt
        Candle::whereNull('open_at')
        ->orderBy('timestamp')
        // ->count());
        ->chunk(
            1000, function (Collection $tickets) {
                $tickets->each(
                    function (Candle $ticket) {
                        // Divide por 3 pq é em segundos e não milisegundos
                        $ticket->open_at = Carbon::createFromTimestamp(substr($ticket->timestamp, 0, -3))->toDateTimeString();
                        $ticket->save();
                        // dd($ticket);
                    }
                );
            }
        );
        dd(Candle::whereNull('open_at')->count());
    }
}
