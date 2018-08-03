<?php

namespace Primas\ContentInteraction;

use Primas\Kernel\BaseClient;
use Primas\Kernel\Exceptions\NotAllowException;
use Primas\Kernel\Traits\MetadataTrait;
use Primas\Kernel\Types\Metadata;

/**
 * Content Interaction APIs
 *
 * Class Application
 * @package Primas\ContentInteraction
 */
class Application extends BaseClient
{
    use MetadataTrait;

    /**
     * fixed to relation
     */
    const TYPE = 'relation';
    /**
     *
     */
    const REPORT_TAG = 'share_report';
    /**
     *
     */
    const LIKE_TAG = 'share_like';
    /**
     *
     */
    const COMMENT_TAG = 'share_comment';
    /**
     *
     */
    const STATUS = 'created';

    /**
     * @param string $share_id
     * @param array $parameters
     * @return mixed
     */
    public function getShareMetadata(string $share_id, array $parameters = [])
    {
        $data = $this->get("shares/$share_id" . "?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $share_id
     * @param array $parameters
     * @return mixed
     */
    public function getSharesOfGroupShare(string $share_id, array $parameters = [])
    {
        $data = $this->get("shares/$share_id/shares?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param string $share_id
     * @param array $parameters
     * @return mixed
     */
    public function getShareReports(string $share_id, array $parameters = [])
    {
        $data = $this->get("shares/$share_id/reports?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildReportShare(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::REPORT_TAG,
            "status" => self::STATUS
        ];
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * @param string $share_id
     * @param Metadata $metadata
     * @return mixed
     * @throws \Exception
     */
    public function reportShare(string $share_id, Metadata $metadata)
    {

        $data = $this->post("shares/$share_id/reports", $metadata);

        return $data;
    }

    /**
     * @param string $share_id
     * @param array $parameters
     * @return mixed
     */
    public function getLikesOfGroupShare(string $share_id, array $parameters = [])
    {
        $data = $this->get("shares/$share_id/likes?" . $this->buildQuery($parameters));

        return $data;
    }


    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateLikeOfGroupShare(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::LIKE_TAG,
            "status" => self::STATUS
        ];
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * @param string $share_id
     * @param Metadata $metadata
     * @return mixed
     * @throws \Exception
     */
    public function createLikeOfGroupShare(string $share_id, Metadata $metadata)
    {
        $data = $this->post("shares/$share_id/likes", $metadata);

        return $data;
    }

    /**
     * @param string $share_id
     * @param string $like_id
     * @throws NotAllowException
     */
    public function deleteLikeOfGroupShare(string $share_id, string $like_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $comment_id
     * @return mixed
     */
    public function getReplyCommentsOfComments(string $comment_id)
    {
        $data = $this->get("comments/$comment_id/comments");

        return $data;
    }

    /**
     * @param string $comment_id
     * @param array $parameters
     * @return mixed
     */
    public function getCommentsOfGroupShare(string $comment_id, array $parameters = [])
    {
        $data = $this->get("shares/$comment_id/comments?" . $this->buildQuery($parameters));

        return $data;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function buildCreateCommentOfGroupShare(array $parameters)
    {
        $filters = [
            "version" => self::DTCP_VERSION,
            "type" => self::TYPE,
            "tag" => self::COMMENT_TAG,
            "status" => self::STATUS
        ];
        return $this->beforeSign($parameters, $filters);
    }

    /**
     * @param string $share_id
     * @param Metadata $metadata
     * @return mixed
     * @throws \Exception
     */
    public function createCommentOfGroupShare(string $share_id, Metadata $metadata)
    {
        $data = $this->post("shares/$share_id/comments", $metadata);

        return $data;
    }

    /**
     * @param string $share_id
     * @param string $comment_id
     * @throws NotAllowException
     */
    public function updateCommentOfGroupShare(string $share_id, string $comment_id)
    {
        throw new NotAllowException("This method is not allowed in this version");
    }

    /**
     * @param string $share_id
     * @param string $comment_id
     * @throws NotAllowException
     */
    public function deleteCommentOfGroupShare(string $share_id, string $comment_id)
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

}