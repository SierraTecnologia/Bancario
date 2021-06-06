<?php

namespace Bancario\Events;

use Illuminate\Queue\SerializesModels;
use Support\Components\Database\Schema\Table;

class TraddingPositionOpened
{
    use SerializesModels;

    public $table;

    public function __construct(Table $table)
    {
        $this->table = $table;

        event(new TableChanged($table->name, 'Added'));
    }
}
