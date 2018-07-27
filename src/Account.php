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
    const TYPE = 'object';
    const TAG = 'account';

    /**
     * Get account metadata
     *
     * @param string $account_id
     * @return mixed
     */
    public function getAccounts(string $account_id)
    {
        $response = $this->client->get("/v3/accounts/$account_id/metadata");
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
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
        $response = $this->client->get("/v3/accounts/$account_id/$subId/metadata");
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
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
        $response = $this->client->post("/v3/accounts", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters),
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function updateAccount(array $array)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getAccountCreditsList(string $account_id)
    {
        $response = $this->client->get("/v3/accounts/$account_id/credits");
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountCreditsList(string $account_id, string $subId)
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/credits");
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountContentList(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/content?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountContentList(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/content?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountGroupList(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/groups?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountGroupList(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/groups?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountShares(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountShares(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountSharesByGroup(string $account_id, string $groupId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/groups/$groupId/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountSharesByGroup(string $account_id, string $subId, string $groupId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/groups/$groupId/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountLikes(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/likes?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountLikes(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/likes?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountComments(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/comments?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountComments(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/comments?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountGroupApplications(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/applications/groups?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountGroupApplications(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/applications/groups?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountShareApplications(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/applications/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountShareApplications(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/applications/shares?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountReports(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/reports?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountReports(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/reports?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountNotifications(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/notifications?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountNotifications(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/notifications?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getAccountAvatarMetadata(string $account_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/avatar?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getSubAccountAvatarMetadata(string $account_id, string $subId, array $parameters = [])
    {
        $response = $this->client->get("/v3/accounts/$account_id/$subId/avatar?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
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
        $response = $this->client->get("/v3/accounts/$account_id/avatar/raw?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
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
        $response = $this->client->get("/v3/accounts/$account_id/$subId/avatar/raw?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
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
     * @return string
     * @throws \Exception
     */
    protected function generateData(array $data)
    {
        $metadata = $this->initField($this->removeFields(array_filter($data)));
        return $this->completeMetadata($metadata);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function initField(array $data)
    {
        return array_merge($data, [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::TAG
        ]);
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