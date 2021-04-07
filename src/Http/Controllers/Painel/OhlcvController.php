<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Ohlcv;
use Pedreiro\CrudController;

class OhlcvController extends Controller
{
    use CrudController;

    public function __construct(Ohlcv $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
