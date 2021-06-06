<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\DailyBalance;
use Pedreiro\CrudController;

class DailyBalanceController extends Controller
{
    use CrudController;

    public function __construct(DailyBalance $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
