<?php

namespace Primas\Token;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Exceptions\ParameterException;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Buffer;
use Primas\Kernel\Types\Byte;
use Primas\Kernel\Types\Metadata;
use Ramsey\Uuid\Uuid;

/**
 * Token APIs
 *
 * Class Application
 * @package Primas\Token
 */
class Application extends BaseClient
{
    use MetadataTrait;
    /**
     * fixed to object
     */
    const CREATE_GROUP_TYPE = 'object';
    /**
     * fixed to relation
     */
    const JOIN_GROUP_TYPE = 'relation';
    /**
     * fixed to relation
     */
    const WHITE_GROUP_TYPE = 'relation';
    /**
     * fixed to relation
     */
    const SHARE_GROUP_TYPE = 'relation';
    /**
     * fixed to group
     */
    const CREATE_GROUP_TAG = 'group';
    /**
     * fixed to group_member
     */
    const JOIN_GROUP_TAG = 'group_member';
    /**
     * fixed to group_member_whitelist
     */
    const WHITE_GROUP_TAG = 'group_member_whitelist';
    /**
     * fixed to group_share
     */
    const SHARE_GROUP_TAG = 'group_share';
    /**
     * fixed to created
     */
    const STATUS = 'created';

    /**
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getAccountTokensData()
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens");

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getIncentivesList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getIncentivesStatisticsList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives/stats" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }


    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getIncentivesWithdrawalList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives/withdrawal" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateIncentivesWithdrawal(array $parameters)
    {
        return $this->getRawMetadata($parameters);
    }

    /**
     * @param Metadata $metadata
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function createIncentivesWithdrawal(Metadata $metadata)
    {
        $account_id = $this->getAccountId();
        $data = $this->post("accounts/$account_id/tokens/incentives/withdrawal", $metadata);

        return Json::json_decode($data, true);
    }


    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getPreLockTokenList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/pre_locks" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ParameterException
     */
    public function buildTransaction(array $parameters)
    {
        $this->checkParameters($parameters, ["amount", "address", "nonce"]);
        $amount = $parameters["amount"];
        $amount = gmp_mul($amount, '1000000000000000000');
        $amount = gmp_strval($amount, 16);
        $amount = str_pad($amount, 64, '0', STR_PAD_LEFT);
        $msg = Byte::initWithHex($parameters["address"])->getBinary() . Byte::initWithHex($amount)->getBinary() . Byte::init($parameters["nonce"])->getBinary();
        return $msg;

    }

    /**
     * @param array $parameters
     * @param string $signature
     * @return mixed
     * @throws ParameterException
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function createPreLockTokens(array $parameters, string $signature)
    {
        $account_id = $this->getAccountId();
        $this->checkParameters($parameters, ["amount", "nonce"]);
        $data["amount"] = gmp_mul($parameters["amount"], '1000000000000000000');
        $data["nonce"] = $parameters["nonce"];
        $data["signature"] = $signature;
        $transaction = Json::json_encode($data);
        $post = [
            "transaction" => $transaction
        ];
        $content_type = $this->getHttpOptions()["headers"]["Content-Type"];
        switch ($content_type) {
            case "application/json":
                $data = [
                    "body" => json_encode($post)
                ];
                break;
            case "application/x-www-form-urlencoded":
                $data = [
                    "form_params" => $post
                ];
                break;
            case "multipart/form-data":
                $data = [
                    "multipart" => [
                        [
                            "name" => "transaction",
                            "contents" => $post["transaction"]
                        ]
                    ]
                ];
                break;
        }
        $response = $this->httpClient->post("accounts/$account_id/tokens/pre_locks", $data);
        $content = $response->getBody()->getContents();

        return Json::json_decode($content, true);
    }

    /**
     * @param array $parameters
     * @throws NotAllowException
     * @throws ClientException
     */
    public function unlockPreLockTokens(array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     * @throws ClientException
     */
    public function getLockTokensList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/locks" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["start_date", "end_date", "page", "page_size", "status", "type"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}