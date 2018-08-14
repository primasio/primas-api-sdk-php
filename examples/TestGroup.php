<?php

include "init.php";

class TestGroup extends TestBase
{

    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
            ],
            // "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::group($config);
    }

    public function testCreateGroup($account_id, $avatar_id)
    {
        $parameters = [
            "title" => "test",
            "creator" => json_encode([
                "account_id" => $account_id
            ]),
            "abstract" => "abstract",
            "language" => "zh",
            "category" => "category",
            "avatar" => $avatar_id, //An image id used for avatar.
            "created" => time(),
            "extra" => json_encode([
                "allow_join" => "all",
                "allow_post" => "all"
            ])
        ];
        $metadataJson = $this->app->buildCreateGroup($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $signature);
        $data = $this->app->createGroup($metadata);
        return $data;
    }

    public function testGetGroupMetadata($group_id)
    {
        $query = [];
        return $this->app->getGroupMetadata($group_id, $query);
    }

    public function testJoinGroup($account_id, $group_id)
    {
        $parameters = [
            "src_id" => $account_id,
            "creator" => json_encode([
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ]),
            "dest_id" => $group_id,
            "created" => time(),
           /* "extra" => json_encode([
                "application_status" => "pending",
                "application_expire" => time()
            ])*/
        ];
        $metadataJson = $this->app->buildJoinGroup($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $signature);
        $data = $this->app->joinGroup($group_id,$metadata);
        return $data;
    }

    public function testUpdateGroupMember($parent_dna,$account_id,$group_id,$group_member_id){
        $parameters = [
            "parent_dna" => $parent_dna,
            "creator" => json_encode([
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ]),
            "updated" => time(),
             "extra" => json_encode([
                 "application_status" => "approved",
             ])
        ];
        $metadataJson = $this->app->buildUpdateGroupMember($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $signature);
        $data = $this->app->updateGroupMember($group_id,$group_member_id,$metadata);
        return $data;
    }

    public function testDeleteGroupMember($parent_dna,$account_id,$group_id,$group_member_id){
        $parameters = [
            "parent_dna" => $parent_dna,
            "creator" => json_encode([
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ]),
            "updated" => time()
        ];
        $metadataJson = $this->app->buildDeleteGroupMember($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $signature);
        $data = $this->app->deleteGroupMember($group_id,$group_member_id,$metadata);
        return $data;
    }


}

$account_id = "32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";
// get from create image
$avatar_id = "1539095e78165a1f992c85beb3d471283293776bb8810f6c1be385f4070fbde6";
$app = new TestGroup();
/*$data = $app->testCreateGroup($account_id, $avatar_id);
var_dump($data);
$group_id = $data["data"]["id"];*/
$group_id = "0951a9077b053a00937b99cd4679719b7216f1d05ebf26f7ea17f58733f77e86";
$data = $app->testJoinGroup($account_id, $group_id);

var_dump($data);



