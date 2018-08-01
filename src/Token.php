<?php

namespace Primas;

use Primas\Exceptions\NotAllowException;

/**
 * Token APIs
 *
 * Class Token
 * @package Primas
 */
class Token extends PrimasClient
{
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
     * @param string $account_id
     * @return mixed
     */
    public function getAccountTokensData(string $account_id)
    {
        $data = $this->get("accounts/$account_id/tokens");

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getIncentivesList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/tokens/incentives" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getIncentivesStatisticsList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/tokens/incentives/stats" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getIncentivesWithdrawalList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/tokens/incentives/withdrawal" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function createIncentivesWithdrawal(string $account_id, array $parameters)
    {
        $filters = [];
        $json=$this->generateData($parameters, $filters);
        $data = $this->post("accounts/$account_id/tokens/incentives/withdrawal", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $json,
        ]);

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getPreLockTokenList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/tokens/pre_locks" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $transaction
     * @return mixed
     */
    public function createPreLockTokens(string $account_id, array $transaction)
    {
        $data = $this->post("accounts/$account_id/tokens/pre_locks", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                "transaction" => $transaction
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        return $data;
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @throws NotAllowException
     */
    public function unlockPreLockTokens(string $account_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $account_id
     * @param array $parameters
     * @return mixed
     */
    public function getLockTokensList(string $account_id, array $parameters = [])
    {
        $data = $this->get("accounts/$account_id/tokens/locks" . "?" . $this->buildQuery($parameters));

        return $data;
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