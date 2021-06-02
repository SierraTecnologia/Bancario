<?php

namespace Bancario\Modules\Logic\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use SimpleXMLElement;
use DOMDocument;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class Integration
{

    protected $user = false;

    protected $_connection = null;

    protected $error = null;

    protected $errorCode = null;

    protected $errorMessage = null;

    /**
     * @Serializer\Exclude
     *
     * @var \JMS\Serializer\Serializer
     */
    private $serializer;


    public function __construct($business)
    {
        $this->user = $business;
        if ($business) {
            $this->_connection = $this->getConnection($business);
        }
    }

    /**
     * Retorna se deve efetuar de verdade os pagamentos ou não
     */
    public function isProduction()
    {
        return (config('app.env')=='production');
    }

    /**
     * Recupera connecção com a integração
     */
    protected function getConnection(User $business)
    {
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
    
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Recupera dados em cima de um get de uma api
     */
    public function get($url, $typeRequisiton = 'json', $body = null)
    {
        return $this->requisition('GET', $url, null, $typeRequisiton, $body);
    }

    public function post($url, $params, $typeRequisiton = 'json', $body = null)
    {
        return $this->requisition('POST', $url, $params, $typeRequisiton, $body);
    }

    public function requisition($type, $url, $params = null, $typeRequisiton = 'json', $body = null)
    {

        $headers = [];
        if ($typeRequisiton=='json') {
            $headers = ['content-type' => 'application/x-www-form-urlencoded', 'Accept' => 'application/json'];
        } else if ($typeRequisiton=='xml') {
            // $headers = ['content-type' => 'application/xml; charset=UTF-8']; //, 'Accept' => 'text/xml'
        }

        $options = [
            'headers'  => $headers,
            'form_params' => $params,
            'verify' => false
        ];

        if ($body!==null) {
            $options['body'] = $body;
        }

        Log::info('Fazendo requisição '.$url.' com params e Options'.print_r($params, true).print_r($options, true));
        $client = new \GuzzleHttp\Client();
        $result = $client->request(
            $type,
            $url,
            $options
        );

        // // Get all of the response headers.
        // foreach ($result->getHeaders() as $name => $values) {
        //     echo $name . ': ' . implode(', ', $values) . "\r\n";
        // }

        // Log::debug('Resposta: '.$result->getBody()->getContents());

        return $result->getBody();
    }

    public function postJson($url, $params)
    {
        $result = $this->post(
            $url,
            null,
            'json',
            $this->formBodyRaw($params)
        );
        $resultContent = $result->getContents();
        Log::info('Retornando Content'. $resultContent);
        return json_decode($resultContent);
    }

    public function formBodyRaw($params)
    {
        $return = '';
        if (!empty($params)) {
            foreach ($params as $nome=>$valor) {
                if ($return!=='') {
                    $return .= '&';
                }
                $return .= $nome.'='.$valor;
            }
        }
        return $return;
    }

    public function getXml($url, $params = [])
    {
        $result = $this->get(
            $url,
            $params,
            'xml'
        );

        return $this->xmlDeserialize($result->getContents());
    }

    public function postXml($url, $params = [])
    {
        $result = $this->post(
            $url,
            $params,
            'xml'
        );
        return $this->xmlDeserialize($result->getContents());
    }

    /**
     * @param string           $url
     * @param SimpleXMLElement $body
     *
     * @return SimpleXMLElement
     */
    public function postWithXmlBody($url, SimpleXMLElement $body)
    {
        try {
            return $this->requisition('POST', $url, null, 'xml', $body->asXML());
        } catch (RequestException $error) {
            // Caso ocorreu algum erro
            $this->error = $error->getMessage();
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
            Log::warning(
                'Erro em integração:',
                [
                    'code' => $error->getMessage()
                ]
            );
        }
    }

    /**
     * @param string $url
     *
     * @return SimpleXMLElement
     */
    public function getWithXmlBody($url)
    {
        try {
            return $this->getXml($url);
        } catch (RequestException $error) {
            // Caso ocorreu algum erro
            $this->error = $error->getMessage();
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
            Log::warning(
                'Erro em integração:',
                [
                    'code' => $error->getMessage()
                ]
            );
        }
    }
    
    /**
     * @return \JMS\Serializer\Serializer
     */
    public function getSerializer()
    {
        if ($this->serializer === null) {
            $this->serializer = SerializerBuilder::create()
                ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
                ->build();
        }

        return $this->serializer;
    }


    /**
     * @param SimpleXMLElement|null $xmlRoot
     *
     * @return SimpleXMLElement
     */
    public function xmlSerialize(SimpleXMLElement $xmlRoot = null)
    {
        $xmlString = $this->getSerializer()->serialize($this, 'xml');
        $xmlObject = new SimpleXMLElement($xmlString);

        if ($xmlRoot === null) {
            return $xmlObject;
        }

        $domRoot = dom_import_simplexml($xmlRoot);
        $domObject = dom_import_simplexml($xmlObject);

        $domRoot->appendChild($domRoot->ownerDocument->importNode($domObject, true));

        return $xmlRoot;
    }

    public function xmlDeserialize($string)
    {
        if (empty($string) || !$this->isValidXml($string)) {
            return $string;
        }
        Log::info('Recebendo resposta: '.$string);
        return new SimpleXMLElement($string);
        // return simplexml_load_string($string);
    }

    /**
     *  Takes XML string and returns a boolean result where valid XML returns true
     */
    function isValidXml( $xml )
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML($xml);
        $errors = libxml_get_errors();
        return empty($errors);
    }
}
