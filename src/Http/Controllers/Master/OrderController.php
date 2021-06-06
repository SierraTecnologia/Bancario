<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\Order;
use Pedreiro\CrudController;

class OrderController extends Controller
{
    use CrudController;

    public function __construct(Order $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
