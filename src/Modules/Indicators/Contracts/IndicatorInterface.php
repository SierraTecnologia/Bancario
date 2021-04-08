<?php

namespace Bancario\Modules\Indicators\Contracts;

interface IndicatorInterface
{
    public function runForEach($value);

    public function calcule();
}
