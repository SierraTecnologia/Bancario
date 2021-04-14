<?php

namespace Bancario\Modules\Graph\Resources;

use Muleta\Modules\Eloquents\Displays\ResourceAbstract;
use Carbon\Carbon;

class CandleResource extends ResourceAbstract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // 'id');
		// 	$table->bigInteger('timestamp');
		// 	$table->double('open', 8, 2);
		// 	$table->double('close', 8, 2);
		// 	$table->double('high', 8, 2);
		// 	$table->double('low', 8, 2);
		// 	$table->double('volume', 8, 2);
		// 	$table->string('symbol');
		// 	$table->string('exchange
        return [
            // 'id'                => $this->id,
            // 'timestamp'         => $this->timestamp,
            'tempo'              => Carbon::createFromTimestamp($this->timestamp)->toDateTimeString(),
            'open'              => (float) $this->open,
            'close'             => (float) $this->close,
            'high'              => (float) $this->high,
            'low'               => (float) $this->low,
            'volume'            => (float) $this->volume,
            // 'symbol'            => $this->symbol,
            // 'id'                => $this->id,
            // 'name'              => $this->name,
            // 'is_active'         => $this->is_active,
            // 'status'            => $this->status,
            // 'videos'            => VideoResource::collection($this->videos),
            // 'created_at'        => (string) $this->created_at,
            // 'updated_at'        => (string) $this->updated_at
        ];
    }
}
