<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\ExchangePair;
use Pedreiro\CrudController;

class ExchangePairController extends Controller
{
    use CrudController;

    public function __construct(ExchangePair $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
