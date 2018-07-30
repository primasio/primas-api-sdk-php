<?php

namespace Primas;

use Primas\Exceptions\NotAllowException;

/**
 * Content Interaction APIs
 *
 * Class ContentInteraction
 * @package Primas
 */
class ContentInteraction extends PrimasClient
{
    const TYPE = 'relation';
    const REPORT_TAG = 'share_report';
    const LIKE_TAG = 'share_like';
    const COMMENT_TAG = 'share_comment';
    const STATUS = 'created';

    public function getShare(string $id, array $parameters = [])
    {
        $data = $this->get("shares/$id" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    public function getSharesOfGroupShare(string $id, array $parameters = [])
    {
        $data = $this->get("shares/$id/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    public function getShareReports(string $id, array $parameters = [])
    {
        $data = $this->get("shares/$id/reports?" . $this->buildQuery($parameters));

        return $data;
    }

    public function reportShare(string $id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::REPORT_TAG,
            "status" => self::STATUS
        ];
        $data = $this->post("shares/$id/reports", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters, $filters),
        ]);

        return $data;
    }

    public function getLikesOfGroupShare(string $id, array $parameters = [])
    {
        $data = $this->get("shares/$id/likes?" . $this->buildQuery($parameters));

        return $data;
    }

    public function createLikeOfGroupShare(string $id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::LIKE_TAG,
            "status" => self::STATUS
        ];
        $data = $this->post("shares/$id/likes", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters,$filters),
        ]);

        return $data;
    }

    public function deleteLikeOfGroupShare(string $share_id,string $like_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function getReplyCommentsOfComments(string $id)
    {
        $data = $this->get("comments/$id/comments");

        return $data;
    }

    public function getCommentsOfGroupShare(string $id, array $parameters = [])
    {
        $data = $this->get("shares/$id/comments?" . $this->buildQuery($parameters));

        return $data;
    }

    public function createCommentOfGroupShare(string $id, array $parameters)
    {
        $filters = [
            "version" => Primas::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::COMMENT_TAG,
            "status" => self::STATUS
        ];
        $data = $this->post("shares/$id/comments", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $this->generateData($parameters,$filters),
        ]);

        return $data;
    }

    public function updateCommentOfGroupShare(string $share_id,string $comment_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    public function deleteCommentOfGroupShare(string $share_id,string $comment_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildQuery(array $parameters)
    {
        return http_build_query(array_filter($parameters, function ($k) {
            return in_array($k, ["page", "page_size", "account_id", "report_status"]);
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