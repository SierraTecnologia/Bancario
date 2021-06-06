<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\CompletedTrade;
use Pedreiro\CrudController;

class CompletedTradeController extends Controller
{
    use CrudController;

    public function __construct(CompletedTrade $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
