<?php

namespace Bancario\Http\Controllers\Admin;

use Bancario\Models\Trader\Asset;
use Pedreiro\CrudController;

class AssetController extends Controller
{
    use CrudController;

    public function __construct(Asset $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
