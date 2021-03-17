<?php

namespace Bancario\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use SierraTecnologia\Customer;
// use SierraTecnologia\SierraTecnologia;

/**
 * Account methods for billing controls
 */
class TraderAccountService
{
    protected $user;
    protected $config;
    protected $subscription;
    protected $inBillingCycle;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->config = \Illuminate\Support\Facades\Config::get('plans');
        $this->subscription = $this->user->meta->subscription($this->config['subscription_name']);
        $this->inBillingCycle = false;

        SierraTecnologia::setApiKey(\Illuminate\Support\Facades\Config::get('services.sitecpayment.secret'));
    }

}
