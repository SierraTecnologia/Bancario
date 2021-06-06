<?php 

namespace Bancario\Manipule;

interface StrategyInterface
{
    public function getQuantidadeAVender();

    public function getQuantidadeAComprar();

    // public static function fromWKT($wkt);

    // public function __toString();

    // public static function fromString($wktArgument);
}
