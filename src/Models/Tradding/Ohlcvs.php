<?php

namespace Bancario\Models\Tradding;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $exchanges_id
 * @property string $symbol
 * @property integer $timestamp
 * @property string $datetime
 * @property float $open
 * @property float $high
 * @property float $low
 * @property float $close
 * @property float $volume
 * @property string $updated_at
 * @property string $created_at
 * @property string $deleted_at
 */
class Ohlcvs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['exchanges_id', 'symbol', 'timestamp', 'datetime', 'open', 'high', 'low', 'close', 'volume', 'updated_at', 'created_at', 'deleted_at'];

}
