<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\ExchangeAccount;
use Pedreiro\CrudController;

class ExchangeAccountController extends Controller
{
    use CrudController;

    public function __construct(ExchangeAccount $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
