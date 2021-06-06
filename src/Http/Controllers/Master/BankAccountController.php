<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\BankAccount;
use Pedreiro\CrudController;

class BankAccountController extends Controller
{
    use CrudController;

    public function __construct(BankAccount $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
