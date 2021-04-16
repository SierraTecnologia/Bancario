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
class TimeScaleService
{
    protected $timeslice = 60;
    protected $periodSize = '1m';
    protected $timescale = '1 minute';
    // protected $subscription;
    // protected $inBillingCycle;

    public function __construct($periodSize = '1m')
    {

        $this->timeslice = 60;
        switch($periodSize) {
        case '1m':
            $this->timescale = '1 minute';
            $this->timeslice = 60;
            break;
        case '5m':
            $this->timescale = '5 minutes';
            $this->timeslice = 300;
            break;
        case '10m':
            $this->timescale = '10 minutes';
            $this->timeslice = 600;
            break;
        case '15m':
            $this->timescale = '15 minutes';
            $this->timeslice = 900;
            break;
        case '30m':
            $this->timescale = '30 minutes';
            $this->timeslice = 1800;
            break;
        case '1h':
            $this->timescale = '1 hour';
            $this->timeslice = 3600;
            break;
        case '4h':
            $this->timescale = '4 hours';
            $this->timeslice = 14400;
            break;
        case '1d':
            $this->timescale = '1 day';
            $this->timeslice = 86400;
            break;
        case '1w':
            $this->timescale = '1 week';
            $this->timeslice = 604800;
            break;
        }
        // $this->currentTime = time();
    }

    public function getOffset($limitResults)
    {
        return ($this->currentTime - ($this->timeslice * $limit)) -1;
    }

}
