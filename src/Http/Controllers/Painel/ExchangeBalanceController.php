<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\ExchangeBalance;
use Pedreiro\CrudController;

class ExchangeBalanceController extends Controller
{
    use CrudController;

    public function __construct(ExchangeBalance $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
