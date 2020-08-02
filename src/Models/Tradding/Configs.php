<?php

namespace Bancario\Models\Tradding;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $item
 * @property string $value
 */
class Configs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['item', 'value', 'exchange_id'];

}
