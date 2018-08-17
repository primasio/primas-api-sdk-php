<?php

namespace Primas\Group;

use GuzzleHttp\Exception\ClientException;
use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Support\Json;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Metadata;

/**
 * Group APIs
 *
 * Class Group
 * @package Primas\Group
 */
class Application extends BaseClient
{
    use MetadataTrait;

    const CREATE_GROUP_TYPE = 'object';

    const JOIN_GROUP_TYPE = 'relation';

    const WHITE_GROUP_TYPE = 'relation';

    const SHARE_GROUP_TYPE = 'relation';

    const CREATE_GROUP_TAG = 'group';

    const JOIN_GROUP_TAG = 'group_member';

    const WHITE_GROUP_TAG = 'group_member_whitelist';

    const SHARE_GROUP_TAG = 'group_share';

    const STATUS = 'created';

    const PUT_STATUS='updated';

    const DELETE_STATUS='deleted';

    /**
     * @param string $group_id
     * @param array $parameters
     * @return mixed
     * @throws  ClientException
     */
    public function getGroupMetadata(string $group_id, array $parameters = [])
    {
        $data = $this->get("groups/$group_id" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data,true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateGroup(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::CREATE_GROUP_TYPE,
            "tag" => self::CREATE_GROUP_TAG,
            "status" => self::STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
}

    /**
     * @param Metadata $metadata
     * @return mixed
     * @throws  ClientException
     */
    public function createGroup(Metadata $metadata)
    {
        $data = $this->post("groups", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param string $group_id
     * @throws NotAllowException
     * @throws ClientException
     */
    public function updateGroup(string $group_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $group_id
     * @throws NotAllowException
     * @throws ClientException
     */
    public function deleteGroup(string $group_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $group_id
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function getGroupMembers(string $group_id, array $parameters = [])
    {
        $data = $this->get("groups/$group_id/members" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data,true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildJoinGroup(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::JOIN_GROUP_TYPE,
            "tag" => self::JOIN_GROUP_TAG,
            "status" => self::STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
    }

    /**
     * join group
     *
     * @param string $group_id
     * @param Metadata $metadata
     * @return mixed
     * @throws ClientException
     */
    public function joinGroup(string $group_id, Metadata $metadata)
    {
        $data = $this->post("groups/$group_id/members", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildUpdateGroupMember(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::JOIN_GROUP_TYPE,
            "tag" => self::JOIN_GROUP_TAG,
            "status" => self::PUT_STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
    }

    /**
     * @param string $group_id
     * @param string $group_member_id
     * @param Metadata $metadata
     * @return mixed
     * @throws ClientException
     */
    public function updateGroupMember(string $group_id, string $group_member_id, Metadata $metadata)
    {
        $data = $this->put("groups/{$group_id}/members/{$group_member_id}", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildDeleteGroupMember(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::JOIN_GROUP_TYPE,
            "tag" => self::JOIN_GROUP_TAG,
            "status" => self::DELETE_STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
    }

    /**
     * @param string $group_id
     * @param string $group_member_id
     * @param Metadata $metadata
     * @return mixed
     * @throws ClientException
     */
    public function deleteGroupMember(string $group_id, string $group_member_id, Metadata $metadata)
    {
        $data = $this->delete("groups/{$group_id}/members/{$group_member_id}", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param string $group_id
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function getGroupMemberWhiteLists(string $group_id, array $parameters = [])
    {
        $data = $this->get("groups/$group_id/members/whitelist/members" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data,true);
    }


    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateGroupMemberWhiteLists(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::WHITE_GROUP_TYPE,
            "tag" => self::WHITE_GROUP_TAG,
            "status" => self::STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
    }

    /**
     * @param string $group_id
     * @param Metadata $metadata
     * @return mixed
     * @throws ClientException
     */
    public function createGroupMemberWhiteLists(string $group_id, Metadata $metadata)
    {
        $data = $this->post("groups/$group_id/members/whitelist/members", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param string $group_id
     * @param string $whitelist_id
     * @param array $parameters
     * @throws NotAllowException
     * @throws ClientException
     */
    public function updateGroupMemberWhiteLists(string $group_id, string $whitelist_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $group_id
     * @param string $whitelist_id
     * @param array $parameters
     * @throws NotAllowException
     * @throws ClientException
     */
    public function deleteGroupMemberWhiteLists(string $group_id, string $whitelist_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $group_id
     * @param array $parameters
     * @return mixed
     * @throws ClientException
     */
    public function getGroupShares(string $group_id, array $parameters = [])
    {
        $data = $this->get("groups/$group_id/shares" . "?" . $this->buildQuery($parameters));

        return Json::json_decode($data,true);
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateShareToGroup(array $parameters){
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::SHARE_GROUP_TYPE,
            "tag" => self::SHARE_GROUP_TAG,
            "status" => self::STATUS
        ];
        return $this->getRawMetadata($parameters,$filters);
    }

    /**
     * @param string $group_id
     * @param Metadata $metadata
     * @return mixed
     * @throws ClientException
     */
    public function createShareToGroup(string $group_id, Metadata $metadata)
    {
        $data = $this->post("groups/$group_id/shares", $metadata);

        return Json::json_decode($data,true);
    }

    /**
     * @param string $share_id
     * @param array $parameters
     * @throws NotAllowException
     * @throws ClientException
     */
    public function updateShare(string $share_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $share_id
     * @param array $parameters
     * @throws NotAllowException
     * @throws ClientException
     */
    public function deleteShare(string $share_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $group_id
     * @return mixed
     * @throws ClientException
     */
    public function getGroupAvatarMetadata(string $group_id)
    {
        $data = $this->get("groups/$group_id/avatar");

        return Json::json_decode($data,true);
    }

    /**
     * @param string $group_id
     * @return string
     * @throws ClientException
     */
    public function getGroupAvatarRawImage(string $group_id)
    {
        $data = $this->get("groups/$group_id/avatar/raw");

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["page", "page_size", "account_id", "application_status"]);
        }, ARRAY_FILTER_USE_KEY));
    }

}