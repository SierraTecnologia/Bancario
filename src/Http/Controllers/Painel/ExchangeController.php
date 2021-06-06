<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Exchange;
use Pedreiro\CrudController;

class ExchangeController extends Controller
{
    use CrudController;

    public function __construct(Exchange $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
