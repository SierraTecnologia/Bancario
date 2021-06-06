<?php

namespace Bancario\Modules\Logic\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\Shopping\Order;

class Business
{
    protected $url = '';

    protected $companyToken = false;
    
    protected $secretToken = false;

    public function __construct($baseUrl, $companyToken = false, $secretToken = false)
    {
        $this->url = $baseUrl;
        $this->companyToken = $companyToken;
        $this->secretToken = $secretToken;
    }


    /**
     * ===========================================================
     * ===========================================================
     * ===========================================================
     * ********** Funções que devem ser sobrescritas  *************
     * ===========================================================
     * ===========================================================
     * ===========================================================
     */
    public function foundOrganizerDataByToken($companyToken)
    {
        return false;
    }

    public function changeStatusOrder(Order $order)
    {
        return false;
    }

    /**
     * params[cpf]
     * params[email]
     * params[telephone]
     */
    public function blockUser($params)
    {
        return false;
    }



    /**
     * ===========================================================
     * ===========================================================
     * ===========================================================
     * ********** Funções para auxilio nas requisições ************
     * ===========================================================
     * ===========================================================
     * ===========================================================
     */
    protected function postWithCompanyToken($url, $params, $returnObject = true)
    {
        if (!isset($params['token'])) {
            $params['token'] = $this->companyToken;
        }
        return $this->post($url, $params, $returnObject);
    }

    protected function post($endPoint, $data, $returnObject = true)
    {
        $data = (is_array($data)) ? http_build_query($data) : $data; 

        $curl = curl_init($this->url .'/'.$endPoint);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        if ($returnObject) {
            return json_decode($result);
        }
        return json_decode($result, true);
    }

    protected function postWithAuthentication($endPoint, $data, $authenticationToken, $returnObject = true)
    {
        $data = (is_array($data)) ? http_build_query($data) : $data; 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url .'/'.$endPoint);
        curl_setopt(
            $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic '.$authenticationToken)
        );
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        // 'Authorization: Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj'));
        // NTViNjJiYjAtNDAyNy00NmM0LWJmNmUtYWI4OTRkODExMWUz
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        curl_close($curl);

        if ($returnObject) {
            return json_decode($result);
        }
        return json_decode($result, true);
    }

    protected function get($endPoint, $returnObject = true)
    {
        // make request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url .'/'.$endPoint); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($curl);
        // handle error; error output
        if(curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return false;
        }
        curl_close($curl);

        if ($returnObject) {
            return json_decode($result);
        }
        return json_decode($result, true);
    }



}
