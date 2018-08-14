<?php

namespace Primas\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\Exceptions\ErrorConfigException;
use Primas\Kernel\Exceptions\ParameterException;
use Primas\Kernel\Support\Json;

/**
 * Class BaseClient
 *
 * @method  mixed               get(...$arguments)
 * @method  mixed               post(...$arguments)
 * @method  mixed               put(...$arguments)
 * @method  mixed               delete(...$arguments)
 * @throws  ClientException
 *
 * @package Primas\Kernel
 */
abstract class BaseClient
{
    /**
     * DTCP VERSION
     */
    const DTCP_VERSION = "1.0";

    /**
     * Server version
     */
    const SERVER_VERSION = "v3";

    /**
     * primas api request options
     * @var array
     */
    private $httpOptions = array();

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @param $account_id
     */
    public function setAccountId($account_id)
    {
        $this->accountId = $account_id;
    }

    /**
     * @return mixed|string
     * @throws ErrorConfigException
     */
    public function getAccountId()
    {
        if ($this->accountId)
            return $this->accountId;
        throw new ErrorConfigException("not found account_id");
    }

    /**
     * @return array
     */
    public function getHttpOptions(): array
    {
        $options = [
            'base_uri' => 'https://rigel-a.primas.network/' . self::SERVER_VERSION . "/",
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ];
        return array_replace_recursive($options, $this->httpOptions);
    }

    public function __construct(array $config = [])
    {
        $this->httpOptions = $config["http_options"] ?? [];
        if (isset($this->httpOptions['base_uri'])) {
            $this->httpOptions['base_uri'] = $this->httpOptions['base_uri'] . "/" . self::SERVER_VERSION . "/";
        }
        if (isset($this->httpOptions['headers']) && isset($this->httpOptions['headers']['Content-Type'])) {
            if (!in_array($this->httpOptions['headers']['Content-Type'], ['application/json', 'multipart/form-data', 'application/x-www-form-urlencoded'])) {
                throw new ErrorConfigException("Content-Type:{$this->httpOptions['headers']['Content-Type']} is not allowed!");
            }
        }
        $this->httpClient = new Client($this->getHttpOptions());
        $this->accountId = $config["account_id"] ?? "";
    }

    /**
     * @param $function
     * @param $arguments
     * @throws ClientException
     * @return string
     */
    public function __call($function, $arguments)
    {
        switch ($function) {
            case "post":
            case "put":
            case "delete":
                if (isset($arguments[1])) {
                    $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
                    switch ($content_type) {
                        case "application/json":
                            $arguments[1] = [
                                "body" => $arguments[1]->toJson()
                            ];
                            break;
                        case "application/x-www-form-urlencoded":
                            $arguments[1] = [
                                "form_params" => $arguments[1]->toFormParams()
                            ];
                            break;
                        case "multipart/form-data":
                            $arguments[1] = [
                                "multipart" => $arguments[1]->toMultipart()
                            ];
                            break;
                    }
                }
                break;
        }
        $response = $this->httpClient->$function(...$arguments);
        $content = $response->getBody()->getContents();
        return $content;
    }

    /**
     * @param array $parameters
     * @param array $items
     * @throws ParameterException
     */
    public function checkParameters(array $parameters,array $items){
        foreach ($items as $item){
            if(!isset($parameters[$item])){
                throw new ParameterException("The field {$item} must exists!");
            }
        }
    }
}