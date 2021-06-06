<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\TraddingHistory;
use Pedreiro\CrudController;

class TraddingHistoryController extends Controller
{
    use CrudController;

    public function __construct(TraddingHistory $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
