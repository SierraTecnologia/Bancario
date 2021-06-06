<?php

namespace Bancario\Events;

use Illuminate\Queue\SerializesModels;

class TraddingPositionReduced
{
    use SerializesModels;

    public $name;

    public function __construct(array $name)
    {
        $this->name = $name;

        event(new TableChanged($name['name'], 'Updated'));
    }
}
