<?php

namespace Bancario\Events;

use Illuminate\Queue\SerializesModels;

class TraddingPositionIncreased
{
    use SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;

        event(new TableChanged($name, 'Deleted'));
    }
}
