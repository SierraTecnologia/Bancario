<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\Trade;
use Pedreiro\CrudController;

class TradeController extends Controller
{
    use CrudController;

    public function __construct(Trade $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
