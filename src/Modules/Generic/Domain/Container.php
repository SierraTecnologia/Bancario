<?php declare(strict_types=1);


namespace Bancario\Modules\Generic\Domain;


use Illuminate\Support\Collection;

abstract class Container
{

    /**
     * @var Collection
     */
    protected $items;
}
