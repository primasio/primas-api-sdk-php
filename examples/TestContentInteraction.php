<?php

include "init.php";

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
        $this->account_id = "e89c51db3e8b1130944a1d98308ec101d0c01cce3407e2d3d5d71e7f19e5dea9";
        // you can get share_id by share to a group
        $this->share_id = "4953d9efc70c9814be331680c843b90997713f3043b7b9069e9fb721e8728502";
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
            "hp" => 5
        ];
        $metadataJson = $this->app->buildCreateLikeOfGroupShare($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $createLikeOfGroupShare = $this->app->createLikeOfGroupShare($share_id, $metadata);
        return $createLikeOfGroupShare;
    }

    public function testCreateCommentOfGroupShare($share_id,$comment_id="")
    {
        $parameters = [
            "src_id" => $this->account_id,
            "dest_id" => $share_id,
            "creator" => json_encode([
                "account_id" => $this->account_id
            ]),
            "created" => time(),
            "extra" => [
                "parent_comment_id"=>$comment_id,
                "content" => "test",
                "content_hash" => \Primas\Kernel\Crypto\Keccak::hash("test")
            ],
            "hp" => 2
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
    public function testGetReplyCommentsOfComments($comment_id)
    {
        $getReplyCommentsOfComments = $this->app->getReplyCommentsOfComments($comment_id);
        return $getReplyCommentsOfComments;
    }

    public function testGetCommentsOfGroupShare($share_id)
    {
        $data = $this->app->getCommentsOfGroupShare($share_id);
        return $data;
    }

}

$app = new TestContentInteraction();

$share_id =  '4953d9efc70c9814be331680c843b90997713f3043b7b9069e9fb721e8728502';

$data = $app->testGetCommentsOfGroupShare($share_id);
var_dump($data);exit;

//$share=$app->testGetShareMetadata($share_id);

/*$data=$app->testCreateLikeOfGroupShare($share_id);
var_dump($data);*/


/*$data=$app->testCreateCommentOfGroupShare($share_id);
var_dump($data);*/

/*
 * comment_id   03827169fe5c4e106da0b612ce26f4fecc3138af065a1fa221f28f2710c231c3
 * comment_dna  642385f8a48afb2203961c83e60a93bb5bd856498bd4b4d8f75cdd0de141c755
 */


$comment_id = "03827169fe5c4e106da0b612ce26f4fecc3138af065a1fa221f28f2710c231c3";
$data=$app->testCreateCommentOfGroupShare($share_id,$comment_id);
var_dump($data);


