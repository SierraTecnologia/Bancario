<?php

namespace Bancario\Http\Controllers\Master;

use Bancario\Models\Jesse\Candle;
use Pedreiro\CrudController;

class CandleController extends Controller
{
    use CrudController;

    public function __construct(Candle $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
