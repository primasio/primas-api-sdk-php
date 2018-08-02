<?php

namespace Primas\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\Exceptions\ErrorConfigException;

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
     * @var bool
     */
    private $keystore = false;

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
    public function setAccountId($account_id){
        $this->accountId=$account_id;
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
        ];
        return array_merge($options, $this->httpOptions);
    }

    /**
     * @return bool
     */
    public function isKeystore(): bool
    {
        return $this->keystore;
    }

    public function __construct(array $config = [])
    {
        $this->httpOptions = $config["http_options"] ?? [];
        $this->httpOptions['headers'] = [
            'Content-Type' => 'application/json',
        ];
        if (isset($this->httpOptions['base_uri'])) {
            $this->httpOptions['base_uri'] = $this->httpOptions['base_uri'] . "/" . self::SERVER_VERSION . "/";
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
        $response = $this->httpClient->$function(...$arguments);
        $content = $response->getBody()->getContents();
        return json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
    }
}