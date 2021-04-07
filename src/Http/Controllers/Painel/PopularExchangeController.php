<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\PopularExchange;
use Pedreiro\CrudController;

class PopularExchangeController extends Controller
{
    use CrudController;

    public function __construct(PopularExchange $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
