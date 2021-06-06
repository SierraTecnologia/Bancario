<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\Ticker;
use Pedreiro\CrudController;

class TickerController extends Controller
{
    use CrudController;

    public function __construct(Ticker $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
