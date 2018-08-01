<?php

namespace Primas;

use Primas\Exceptions\NotAllowException;

/**
 * Account APIs
 *
 * Class Account
 * @package Primas
 */
class Account extends PrimasClient
{
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
     * @param string $account_id
     * @return mixed
     */
    public function getAccounts(string $account_id)
    {
        $data = $this->get("accounts/$account_id/metadata");

        return $data;
    }

    /**
     * Get sub account metadata
     * @param string $account_id
     * @param string $subId
     * @return mixed
     */
    public function getSubAccounts(string $account_id, string $subId)
    {
        $data = $this->get("accounts/$account_id/sub/$subId/metadata");

        return $data;
    }

    /**
     * Create account
     *
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function createAccount(array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::TAG,
            "status" => self::CREATED_STATUS
        ];
        $data = $this->post("accounts", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);

        return $data;
    }

    /**
     * Update account metadata
     *
     * @param array $array
     * @throws NotAllowException
     */
    public function updateAccount(array $array)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * Get account credits list
     *
     * @param string $account_id
     * @return mixed
     */
    public function getAccountCreditsList(string $account_id)
    {
        $data = $this->get("accounts/$account_id/credits");

        return $data;
    }

    /**
     * Get account content list
     *
     * @param string $account_id
     * @param string $subId
     * @return mixed
     */
    public function getSubAccountCreditsList(string $account_id, string $subId)
    {
        $data = $this->get("accounts/$account_id/sub/$subId/credits");

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountContentList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/content?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountContentList(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/content?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountGroupList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/groups?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountGroupList(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/groups?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountShares(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountShares(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $groupId
     * @param array $parameters
     * @return mixed
     */
    public function getAccountSharesByGroup(string $account_id, string $groupId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/groups/$groupId/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param string $groupId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountSharesByGroup(string $account_id, string $subId, string $groupId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/groups/$groupId/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountLikes(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/likes?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountLikes(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/likes?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountComments(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/comments?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountComments(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/comments?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountGroupApplications(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/applications/groups?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountGroupApplications(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/applications/groups?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountShareApplications(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/applications/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountShareApplications(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/applications/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountReports(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/reports?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountReports(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/reports?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountNotifications(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/notifications?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountNotifications(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/notifications?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountAvatarMetadata(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/avatar?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountAvatarMetadata(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/avatar?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     *  Get  account avatar raw image
     *
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getAccountAvatarRaw(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/avatar/raw?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     *  Get sub account avatar raw image
     *
     * @param string $account_id
     * @param string $subId
     * @param array $parameters
     * @return mixed
     */
    public function getSubAccountAvatarRaw(string $account_id, string $subId, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/sub/$subId/avatar/raw?" . $this->buildQuery($parameters));

        return $data;
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

    /**
     * @param array $data
     * @param array $filters
     * @return string
     * @throws \Exception
     */
    protected function generateData(array $data, array $filters)
    {
        $metadata = $this->initField($this->removeFields(array_filter($data)), $filters);
        return $this->completeMetadata($metadata);
    }

    /**
     * @param array $data
     * @param array $filters
     * @return array
     */
    protected function initField(array $data, array $filters)
    {
        return array_merge($data, $filters);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function removeFields(array $data)
    {
        $removeFields = ['signature'];
        foreach ($removeFields as $field) {
            if (isset($data[$field])) unset($data[$field]);
        }
        return $data;
    }

}