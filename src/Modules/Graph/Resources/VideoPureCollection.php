<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Muleta\Modules\Eloquents\Displays\CollectionAbstract;

class GraphCollection extends CollectionAbstract
{
    
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = GraphResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
