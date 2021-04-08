<?php

namespace Bancario\Modules\Graph\Resources;

use Muleta\Modules\Eloquents\Displays\ResourceAbstract;

class GraphResource extends ResourceAbstract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'id'                => $this->id,
        //     'name'              => $this->name,
        //     'is_active'         => $this->is_active,
        //     'status'            => $this->status,
        //     'videos'            => VideoResource::collection($this->videos),
        //     'created_at'        => (string) $this->created_at,
        //     'updated_at'        => (string) $this->updated_at
        // ];
    }
}
