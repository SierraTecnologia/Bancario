<?php

namespace Bancario\Traits;

use Log;

trait HasServicesAndAccounts
{
    /**
     * Get all of the post's accounts.
     */
    public function accounts()
    {
        return $this->morphToMany('Bancario\Models\Digital\Account', 'accountable');
    }

    

}
