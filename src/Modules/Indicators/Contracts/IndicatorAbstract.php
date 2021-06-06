<?php

namespace Bancario\Modules\Indicators\Contracts;

abstract class IndicatorAbstract
{
    use IndicatorTrait;

    public function getCode()
    {
        $this->code;
    }
}
