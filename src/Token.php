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
    const CREATE_GROUP_TYPE = 'object';
    const JOIN_GROUP_TYPE = 'relation';
    const WHITE_GROUP_TYPE = 'relation';
    const SHARE_GROUP_TYPE = 'relation';
    const CREATE_GROUP_TAG = 'group';
    const JOIN_GROUP_TAG = 'group_member';
    const WHITE_GROUP_TAG = 'group_member_whitelist';
    const SHARE_GROUP_TAG = 'group_share';
    const STATUS = 'created';

    public function getAccountTokensData(string $account_id)
    {
        $data = $this->get("/v3/accounts/$account_id/tokens");

        return $data;
    }

    public function getIncentivesList(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/tokens/incentives" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    public function getIncentivesStatisticsList(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/tokens/incentives/stats" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    public function getIncentivesWithdrawalList(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/tokens/incentives/withdrawal" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    public function createIncentivesWithdrawal(string $account_id, array $parameters)
    {
        $filters = [];
        $json=$this->generateData($parameters, $filters);
        $data = $this->post("/v3/accounts/$account_id/tokens/incentives/withdrawal", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $json,
        ]);

        return $data;
    }

    public function getPreLockTokenList(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/tokens/pre_locks" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    public function createPreLockTokens(string $account_id, array $transaction)
    {
        $data = $this->post("/v3/accounts/$account_id/tokens/pre_locks", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                "transaction" => $transaction
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        return $data;
    }

    public function unlockPreLockTokens(string $account_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getLockTokensList(string $account_id, array $parameters = [])
    {
        $data = $this->get("/v3/accounts/$account_id/tokens/locks" . "?" . $this->buildQuery($parameters));

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

    protected function generateData(array $data, array $filters)
    {
        $metadata = $this->initField($this->removeFields(array_filter($data)), $filters);
        return $this->completeMetadata($metadata);
    }

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