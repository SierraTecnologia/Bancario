<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\ExchangeAddress;
use Pedreiro\CrudController;

class ExchangeAddressController extends Controller
{
    use CrudController;

    public function __construct(ExchangeAddress $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
