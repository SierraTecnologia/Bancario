<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\OrderBook;
use Pedreiro\CrudController;

class OrderBookController extends Controller
{
    use CrudController;

    public function __construct(OrderBook $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
