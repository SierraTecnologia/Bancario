<?php

namespace Bancario\Http\Controllers\Painel;

use Bancario\Models\Tradding\Config;
use Pedreiro\CrudController;

class ConfigController extends Controller
{
    use CrudController;

    public function __construct(Config $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
