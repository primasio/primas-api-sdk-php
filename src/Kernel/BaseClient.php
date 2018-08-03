<?php

namespace Primas\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\Exceptions\ErrorConfigException;
use Primas\Kernel\Support\Json;

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
                throw new ErrorConfigException("{$this->httpOptions['headers']['Content-Type']} is not allowed!");
            }
        }
        $this->httpClient = new Client($this->getHttpOptions());
        $this->accountId = $config["account_id"] ?? "";
    }

    /**
     * @param $function
     * @param $arguments
     * @throws ClientException
     * @return mixed
     */
    public function __call($function, $arguments)
    {
        switch ($function) {
            case "post":
            case "put":
            case "delete":
                if (isset($arguments[1])) {
                    $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
                    if ($content_type === 'application/json') {
                        $arguments[1] = [
                            "body" => $arguments[1]->toJson()
                        ];
                    } elseif ($content_type === 'application/x-www-form-urlencoded') {
                        $arguments[1] = [
                            "form_params" => $arguments[1]->toFormParms()
                        ];
                    } else {
                        $arguments[1] = [
                            "multipart" => $arguments[1]->toMultipart()
                        ];
                    }
                }
                break;
        }
        $response = $this->httpClient->$function(...$arguments);
        $content = $response->getBody()->getContents();
        return Json::json_decode($content, true);
    }
}