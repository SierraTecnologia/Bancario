<?php

namespace Bancario\Modules\Graph\Resources;

use Muleta\Modules\Eloquents\Displays\CollectionAbstract;

class CandleCollection extends CollectionAbstract
{
    
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = CandleResource::class;


    public $filters = [
        
    ];

    // public $filters = [
        
    // ];

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
