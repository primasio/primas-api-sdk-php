<?php

include  "init.php";

/*
 *  getShareReports &reportShare method not allowed in this version
 */

class TestContentInteraction extends TestBase
{
    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            // "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::content_interaction($config);
        // You can use the account_id of the account you created
        $this->account_id = "32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";
        // you can get share_id by share to a group
        $this->share_id = "991aa206959a24d98da165f94c5cfe078713e56dd7e68ee7e4a598d33a8d19d2";
    }

    public function testGetShareMetadata($share_id)
    {
        $query = [
            //  "account_id"=>$account_id  // It's not necessary
        ];

        $getShares = $this->app->getShareMetadata($share_id, $query);
        return $getShares;
    }

    public function testGetSharesOfGroupShare($share_id)
    {
        $query = [
            "page" => 0, // Page number. Starts from 0.
            "page_size" => 20 // Page size. Default to 20.
            //  "account_id"=>$account_id  // It's not necessary
        ];
        $getSharesOfGroupShare = $this->app->getSharesOfGroupShare($share_id, $query);
        return $getSharesOfGroupShare;
    }

    public function testGetLikesOfGroupShare($share_id)
    {
        $getLikesOfGroupShare = $this->app->getLikesOfGroupShare($share_id);
        return $getLikesOfGroupShare;
    }

    public function testCreateLikeOfGroupShare($share_id)
    {
        $parameters = [
            "src_id" => $this->account_id,
            "dest_id" => $share_id,
            "creator" => json_encode([
                "account_id" => $this->account_id
            ]),
            "created" => time(),
        ];
        $metadataJson = $this->app->buildCreateLikeOfGroupShare($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $createLikeOfGroupShare = $this->app->createLikeOfGroupShare($share_id, $metadata);
        return $createLikeOfGroupShare;
    }

    public function testCreateCommentOfGroupShare($share_id)
    {
        $parameters = [
            "src_id" => $this->account_id,
            "dest_id" => $share_id,
            "creator" => json_encode([
                "account_id" => $this->account_id
            ]),
            "created" => time(),
            "extra" => json_encode([
                "content" => "test",
                "content_hash" => \Primas\Kernel\Crypto\Keccak::hash("test")
            ])
        ];
        $metadataJson = $this->app->buildCreateCommentOfGroupShare($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $createCommentOfGroupShare = $this->app->createCommentOfGroupShare($share_id, $metadata);
        return $createCommentOfGroupShare;
    }

    /**
     * you can get comment_id from testCreateCommentOfGroupShare
     *
     * @param $comment_id
     * @return mixed
     */
    public function testGetReplyCommentsOfComments($comment_id){
        $getReplyCommentsOfComments = $this->app->getReplyCommentsOfComments($comment_id);
        return $getReplyCommentsOfComments;
    }

    public function testGetCommentsOfGroupShare($comment_id){
        $data = $this->app->getCommentsOfGroupShare($comment_id);
        return $data;
    }

}

$app=new TestContentInteraction();
// you can get comment_id from testCreateCommentOfGroupShare
$comment_id="6a23275377688c96b25aee06c26d0fa1ba946e7afe81a0b33160598fe047c110";
$res=$app->testGetCommentsOfGroupShare($comment_id);
var_dump($res);
