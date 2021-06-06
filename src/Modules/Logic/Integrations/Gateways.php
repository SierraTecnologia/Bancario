<?php

namespace Bancario\Modules\Logic\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Shopping\Order;

class Gateways extends Integration
{
    public function __construct($business)
    {
        parent::__construct($business);
    }

    public function isErrorByInsufficientFunds()
    {
        return false;
    }

    public function canBeFraud()
    {
        return false;
    }

    /**
     * Avisa ao antifraude que o pedido foi alterado
     */
    public function orderIsChanged(Order $registerOrder)
    {
        return false;
    }

    /**
     * Avisa ao antifraude que o pedido foi alterado
     */
    public function changedOrder(Order $registerOrder)
    {
        return true;
    }
}
