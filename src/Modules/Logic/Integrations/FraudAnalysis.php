<?php

namespace Bancario\Modules\Logic\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Shopping\Order;

class FraudAnalysis extends Integration
{
    public function __construct(User $business)
    {
        parent::__construct($business);
    }

    /**
     * 0 = Pendente
     * 1 = Aprovado
     * 2 = Negado
     */
    protected $_status = 0;

    public function getStatus()
    {
        return $this->_status;
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
