<?php

namespace Primas;

use Primas\Exceptions\NotAllowException;

/**
 * Group APIs
 *
 * Class Group
 * @package Primas
 */
class Group extends PrimasClient
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

    public function getGroupMetadata(string $group_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/groups/$group_id" . "?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function createGroup(array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::CREATE_GROUP_TYPE,
            "tag" => self::CREATE_GROUP_TAG,
            "status" => self::STATUS
        ];
        $response = $this->client->post("/v3/groups", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function updateGroup(string $group_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function deleteGroup(string $group_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getGroupMembers(string $group_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/groups/$group_id/members" . "?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function joinGroup(string $group_id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::JOIN_GROUP_TYPE,
            "tag" => self::JOIN_GROUP_TAG,
            "status" => self::STATUS
        ];
        $response = $this->client->post("/v3/groups/$group_id/members", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function updateGroupMember(string $group_id, string $group_member_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function deleteGroupMember(string $group_id, string $group_member_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getGroupMemberWhiteLists(string $group_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/groups/$group_id/members/whitelist" . "?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function createGroupMemberWhiteLists(string $group_id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::WHITE_GROUP_TYPE,
            "tag" => self::WHITE_GROUP_TAG,
            "status" => self::STATUS
        ];
        $response = $this->client->post("/v3/groups/$group_id/members/whitelist", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function updateGroupMemberWhiteLists(string $group_id, string $whitelist_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function deleteGroupMemberWhiteLists(string $group_id, string $whitelist_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getGroupShares(string $group_id, array $parameters = [])
    {
        $response = $this->client->get("/v3/groups/$group_id/shares" . "?" . $this->buildQuery($parameters));
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function createShareToGroup(string $group_id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::SHARE_GROUP_TYPE,
            "tag" => self::SHARE_GROUP_TAG,
            "status" => self::STATUS
        ];
        $response = $this->client->post("/v3/groups/$group_id/shares", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function updateShare(string $share_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function deleteShare(string $share_id, array $parameters)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getGroupAvatarMetadata(string $group_id)
    {
        $response = $this->client->get("/v3/groups/$group_id/avatar");
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        return $data;
    }

    public function getGroupAvatarRawImage(string $group_id)
    {
        $response = $this->client->get("/v3/groups/$group_id/avatar/raw");
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
            return in_array($k, ["page", "page_size", "account_id", "application_status"]);
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