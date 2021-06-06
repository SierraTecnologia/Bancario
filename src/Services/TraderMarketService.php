<?php

namespace Bancario\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use SierraTecnologia\Customer;
// use Bancario\Models\Trader\TraderMarket;
// use SierraTecnologia\SierraTecnologia;

/**
 * Account methods for billing controls
 */
class TraderMarketService
{
    protected $eloquent;
    // protected $config;
    // protected $subscription;
    // protected $inBillingCycle;

    public function __construct()
    {
        // $eloquent = TraderMarket::firstOrCreate(
        //     [
        //         'exchange_code' => 6, //Binance
        //         'auth_key' => 'afLPF8tuJozZFCnIYd7XMsMoS24jGh26W6kDfb2Gda6qxPjRO1np99hTmGOX733B',
        //         'auth_secret' => 'XQBQAh59fUQNW7inxw7np9tWO6GelnNo9n9qqYp3mPb2Uop9phHrGvN0OJchwIGH',
        //     ]
        // );
    }

}
