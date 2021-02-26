<?php

namespace Bancario\Http\Controllers\Admin;

use Bancario\Models\Money\Money;
use Pedreiro\CrudController;

class MoneyController extends Controller
{
    use CrudController;

    public function __construct(Money $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
