<?php

namespace Primas\Account;

use Primas\Kernel\BaseClient;
use Primas\Kernel\Code;
use Primas\Kernel\Exceptions\ErrorConfigException;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Support\Utils;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Metadata;

/**
 * Account APIs
 *
 * Class Application
 * @package Primas\Account
 */
class Application extends BaseClient
{
    use MetadataTrait;
    /**
     * fixed to 'object'
     */
    const TYPE = 'object';
    /**
     * fixed to 'account'
     */
    const TAG = 'account';
    /**
     * fixed to 'created'
     */
    const CREATED_STATUS = 'created';

    /**
     * Get account metadata
     *
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountMetadata()
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/metadata");

        return Json::json_decode($data, true);
    }

    /**
     * Get sub account metadata
     *
     * @param string $subId
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountMetadata(string $subId)
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/metadata");

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function buildCreateAccount(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::TAG,
            "status" => self::CREATED_STATUS
        ];
        return $this->getRawMetadata($parameters, $filters);
    }

    /**
     * Create account
     *
     * @param Metadata $metadata
     * @return mixed
     * @throws \Exception
     */
    public function createAccount(Metadata $metadata)
    {
        $data = $this->post("accounts", $metadata);
        $result = Json::json_decode($data, true);
        if (isset($result["result_code"]) && $result["result_code"] === Code::OK && isset($result["data"]["id"])) {
            $this->setAccountId($result["data"]["id"]);
        }
        return Json::json_decode($data, true);
    }

    /**
     * Update account metadata
     *
     * @param Metadata $metadata
     * @throws NotAllowException
     */
    public function updateAccount(Metadata $metadata)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * Get account credits list
     *
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountCreditsList()
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/credits");

        return Json::json_decode($data, true);
    }

    /**
     * Get account content list
     *
     * @param string $subId
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountCreditsList(string $subId)
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/credits");

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountContentList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/content?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountContentList(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/content?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountGroupList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/groups?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountGroupList(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/groups?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }


    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountShares(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }


    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountShares(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $groupId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountSharesByGroup(string $groupId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/groups/$groupId/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param string $groupId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountSharesByGroup(string $subId, string $groupId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/groups/$groupId/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountLikes(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/likes?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountLikes(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/likes?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountComments(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/comments?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountComments(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/comments?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountGroupApplications(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/applications/groups?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountGroupApplications(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/applications/groups?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountShareApplications(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/applications/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountShareApplications(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/applications/shares?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountReports(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/reports?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountReports(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/reports?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountNotifications(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/notifications?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountNotifications(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/notifications?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getAccountAvatarMetadata(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/avatar?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return mixed
     * @throws ErrorConfigException
     */
    public function getSubAccountAvatarMetadata(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/avatar?" . $this->buildQuery($parameters));

        return Json::json_decode($data, true);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ErrorConfigException
     */
    public function getAccountAvatarRaw(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/avatar/raw?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $subId
     * @param array $parameters
     * @return string
     * @throws ErrorConfigException
     */
    public function getSubAccountAvatarRaw(string $subId, array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/sub/$subId/avatar/raw?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $address
     * @return mixed
     * @throws \Exception
     */
    public function getAddressMetadata(string $address)
    {
        if (!Utils::hasHexPrefix($address)) {
            throw new \Exception("address must have hex prefix:0x");
        }
        $data = $this->get("main/accounts/{$address}/metadata");

        return Json::json_decode($data);
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["page", "page_size", "application_status", "report_status", "start_time"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}