<?php

namespace Bancario\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use SierraTecnologia\Customer;
use Bancario\Models\Tradding\ExchangeAccount;
// use SierraTecnologia\SierraTecnologia;

/**
 * Account methods for billing controls
 */
class ExchangeAccountService
{
    // protected $user;
    // protected $config;
    // protected $subscription;
    // protected $inBillingCycle;

    public function __construct()
    {
        ExchangeAccount::create(
            [
                'exchange_code' => 'binance', //6, //Binance
                'auth_key' => 'afLPF8tuJozZFCnIYd7XMsMoS24jGh26W6kDfb2Gda6qxPjRO1np99hTmGOX733B',
                'auth_secret' => 'XQBQAh59fUQNW7inxw7np9tWO6GelnNo9n9qqYp3mPb2Uop9phHrGvN0OJchwIGH',
            ]
        );
    }

}
