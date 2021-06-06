<?php

namespace Bancario\Http\Controllers\Admin;

use Bancario\Models\Bank;
use Pedreiro\CrudController;

class BankController extends Controller
{
    use CrudController;

    public function __construct(Bank $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
