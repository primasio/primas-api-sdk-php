<?php

namespace Primas\Token;

use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Metadata;

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
     */
    public function getAccountTokensData()
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens");

        return $data;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function getIncentivesList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function getIncentivesStatisticsList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives/stats" . "?" . $this->buildQuery($parameters));

        return $data;
    }


    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function getIncentivesWithdrawalList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/incentives/withdrawal" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $parameters
     */
    public function buildCreateIncentivesWithdrawal(array $parameters)
    {
        $this->beforeSign($parameters);
    }

    /**
     * @param Metadata $metadata
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function createIncentivesWithdrawal(Metadata $metadata)
    {
        $account_id = $this->getAccountId();
        $data = $this->post("accounts/$account_id/tokens/incentives/withdrawal", $metadata);

        return $data;
    }


    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function getPreLockTokenList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
        $data = $this->get("accounts/$account_id/tokens/pre_locks" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $transaction
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function createPreLockTokens(array $transaction)
    {
        $account_id = $this->getAccountId();
        $metadata = Metadata::init($transaction);
        $data = $this->post("accounts/$account_id/tokens/pre_locks", $metadata);

        return $data;
    }

    /**
     * @param array $parameters
     * @throws NotAllowException
     */
    public function unlockPreLockTokens(array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Primas\Kernel\Exceptions\ErrorConfigException
     */
    public function getLockTokensList(array $parameters = [])
    {
        $account_id = $this->getAccountId();
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

}