<?php

namespace Bancario\Console\Commands;

use Illuminate\Console\Command;

class BacktestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backtest:run';

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
        $builderMetrics = new \Bancario\Modules\Graph\Builders\GraphMetricsBuilder();
        $builderMetrics->build();
    }
}
