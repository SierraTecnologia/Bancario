<?php

namespace Bancario\Modules\Logic\Integrations\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Bancario\Modules\Logic\Integrations\Business;
use App\Models\User;
use App\Models\Shopping\Order;

class Bilo extends Business
{

    // public function registerUser($params)
    // {
    //     Log::debug('[Gateway] Registrando Usuário: '. print_r($params, true));
    //     return $this->postWithCompanyToken('users/register', $params);
    // }

    public function foundOrganizerDataByToken($companyToken)
    {
        return false;
    }
    
}
