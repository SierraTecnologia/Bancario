<?php

namespace Bancario\Modules\Logic\Integrations\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Bancario\Modules\Logic\Integrations\Business;
use App\Models\Shopping\Order;

class Passepague extends Business
{

    // public function registerUser($params)
    // {
    //     Log::debug('[Gateway] Registrando Usuário: '. print_r($params, true));
    //     return $this->postWithCompanyToken('users/register', $params);
    // }

    public function notifyChangeInOrder(Order $order)
    {
        return true;
    }

    public function foundOrganizerDataByToken($companyToken)
    {
        
        Log::debug('[Bilo Business] Buscando Organizer: '. $companyToken);
        $companies = $this->get('companies', []);
        if (empty($companies)) {
            return false;
        }
        
        foreach ($companies as $companie) {
            if ($companie->token==$companyToken) {
                return $companie;
            }
        }

        return false;
    }
    
}
