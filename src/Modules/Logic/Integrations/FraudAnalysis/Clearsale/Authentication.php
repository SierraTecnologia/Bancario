<?php
namespace Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale;

use GuzzleHttp\Client as Http;
use App\Exceptions\AuthenticationException;
use App\Models\IntegrationAuthLogged;
use App\Models\Identitys\FraudAnalysi;
use Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale;

class Authentication
{
    /**
     * Url of authentication production
     *
     * @var string
     */
    private $urlProd = 'https://api.clearsale.com.br/v1/authenticate';

    /**
     * Url of authentication hmg
     *
     * @var string
     */
    private $urlHmg = 'http://homologacao.clearsale.com.br/api/v1/authenticate';

    /**
     * The instance of Guzzle Cliente
     *
     * @var string
     */
    private $http;

    /**
     * The url of authentication
     *
     * @var string
     */
    private $url;

    /**
     * The url of authentication
     *
     * @var string
     */
    public $name;

    /**
     * The url of authentication
     *
     * @var string
     */
    public $password;

    // /**
    //  * Instance logged user
    //  *
    //  * @var \App\Models\IntegrationAuthLogged
    //  */
    // private $logged;

    // public function __construct($name, $password)
    // {
    //     $this->name = $name;
    //     $this->password = $password;
    //     $this->http = new Http;
    //     $this->url = (env('APP_ENV') === 'production') ? $this->getUrlProd() : $this->getUrlHmg();
    // }

    // /**
    //  * Return url of prodution authentication
    //  *
    //  * @return string
    //  */
    // public function getUrlProd()
    // {
    //     return $this->urlProd;
    // }

    // /**
    //  * Return url of hmg authentication
    //  *
    //  * @return string
    //  */
    // public function getUrlHmg()
    // {
    //     return $this->urlHmg;
    // }

    // /**
    //  * Get name authentication login
    //  *
    //  * @return string
    //  */
    // protected function getLoginName()
    // {
    //     return $this->name;
    // }

    // /**
    //  * Get password authentication login
    //  *
    //  * @return string
    //  */
    // protected function getLoginPassword()
    // {
    //     return $this->password;
    // }

    // /**
    //  * Try to attemp login in ClearSale
    //  *
    //  * @param  string                                  $data
    //  * @return \App\Models\IntegrationAuthLogged
    //  * @throws AuthenticationException
    //  */
    // protected function login()
    // {
    //     if (!$login = IntegrationAuthLogged::where([
    //         'name' => $this->getLoginName(),
    //         'password' => $this->getLoginPassword()
    //     ])->first()){
    //         try {
    //             $response = $this->http->request(
    //                 'POST',
    //                 $this->url,
    //                 [
    //                     'headers' => [
    //                         'Content-Type' => 'application/json'
    //                     ],
    //                     'form_params' => [
    //                         'name' => $this->getLoginName(),
    //                         'password' => $this->getLoginPassword()
    //                     ]
    //                 ]
    //             );

    //             $decoded = (array) $response->getBody()->getContent();
    //             $decoded['integration_name'] = FraudAnalysi::class();
    //             $decoded['integration_id'] = Clearsale::$ID;
    //             $this->logged = new IntegrationAuthLogged($decoded);
    //             return $this->logged->save();
    //         } catch (AuthenticationException $ex) {
    //             throw $ex;
    //         }
    //     }
    //     return $login;
    // }
}
