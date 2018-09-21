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
                /*  "allow_join" => "application",
                  "allow_post" => "application"*/
            ])
        ];
        $metadataJson = $this->app->buildCreateGroup($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
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
            "extra" => json_encode([
                "application_status" => "pending",
                "application_expire" => 7200   // unit : second
            ])
        ];
        $metadataJson = $this->app->buildJoinGroup($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->joinGroup($group_id, $metadata);
        return $data;
    }

    public function testUpdateGroupMember($parent_dna, $account_id, $group_id, $group_member_id)
    {
        $parameters = [
            "parent_dna" => $parent_dna,
            "creator" => json_encode([
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ]),
            "updated" => time(),
            "extra" => json_encode([
//                 "application_status" => "approved",
                "application_status" => "declined",
            ])
        ];
        $metadataJson = $this->app->buildUpdateGroupMember($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->updateGroupMember($group_id, $group_member_id, $metadata);
        return $data;
    }

    public function testDeleteGroupMember($parent_dna, $account_id, $group_id, $group_member_id)
    {
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
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->deleteGroupMember($group_id, $group_member_id, $metadata);
        return $data;
    }

    public function testGetGroupMembers($group_id)
    {
        $query = [];
        return $this->app->getGroupMembers($group_id, $query);
    }

    public function testShareToGroup($account_id, $content_id, $group_id, $share_id = "")
    {
        $parameters = [
            "src_id" => $content_id,

            "creator" => json_encode([
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ]),
            "dest_id" => $group_id,
            "created" => time(),
            "hp" => 5,
        ];
        if ($share_id) {
            $parameters["extra"] = json_encode([
                "share_id" => $share_id
            ]);
        }
        $metadataJson = $this->app->buildCreateShareToGroup($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->createShareToGroup($group_id, $metadata);
        return $data;
    }

    public function testUpdateShareToGroup($account_id, $share_id, $share_dna, $application_status)
    {
        $parameters = [
            "parent_dna" => $share_dna,

            "creator" => [
                "account_id" => $account_id,
//                "sub_account_id" =>""
            ],
            "extra" => [
                "application_status" => $application_status
            ],
            "updated" => time(),
        ];

        $metadataJson = $this->app->buildUpdateShareApplication($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->updateShareApplication($share_id, $metadata);
        return $data;
    }

    public function testGetGroupShares($group_id, $parameters = [])
    {
        return json_encode($this->app->getGroupShares($group_id, $parameters));
    }

    public function getGroupMemberWhiteLists($group_id){
        return $this->app->getGroupMemberWhiteLists($group_id);
    }

    public function testCreateGroupMemberWhiteLists($root_account_id,$member_account_id, $group_id)
    {
        $parameters = [
            "src_id" => $member_account_id,   // Member's account ID
            "dest_id" => $group_id,
            "creator" => [
                "account_id" => $root_account_id,    // administrator's account ID
//                "sub_account_id" =>""
            ],
            "extra" => [
                "application_status" => "pending"  // Fixed to pending
            ],
            "created" => time(),
        ];

        $metadataJson = $this->app->buildCreateGroupMemberWhiteLists($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $data = $this->app->createGroupMemberWhiteLists($group_id, $metadata);
        return $data;
    }

}

$account_id = "e89c51db3e8b1130944a1d98308ec101d0c01cce3407e2d3d5d71e7f19e5dea9";
// get from create image
$avatar_id = "fd57c323ff65f38087693d0575feafb6bb10a53fbae280d4365d532d22ad6085";
$app = new TestGroup();

/*$data = $app->testCreateGroup($account_id, $avatar_id);
var_dump($data);*/

//$group_id = $data["data"]["id"];

$public_group_id = "a7234646f4127dd803b1999e23cb791c78cc77bc24797e0d09a5650b81e0b5ff";

//$public_group_id ='5f9d753ff4cb1a628c22099bba6e34a70e12dfbce8518726b6a592ef975c522b';
//$public_group_id = '27f0f3af543d12b418bc1737f08b97980020cd4e2ca7b2b073d366e5ac3bfb83';
$approve_group_id = 'a0d145221a31b3c9604dabad76332442450248e5f955c5d50e2db4c44473bb8d';  // myself
//$approve_group_id = 'cd5f53ab831dcecafb32ef9ea748aa74afce6a96d681ddc34e4ec22b6305338b';

// get group shares
/*$data = $app->testGetGroupShares($approve_group_id,[
    "application_status"=>"declined"
//    "application_status"=>"approved"
//    "application_status"=>"pending"
]);
var_dump($data);exit;*/

/*$share_id='fdbfc5ff59c2395852ac9f84d026243b375aa0640361e05015ea28000e9c99dc';
$share_dna='29ac18693664fd1ef4d8e55a95d549e84879232b5056fa89df821e3258efe5fe';
$data = $app->testUpdateShareToGroup($account_id,$share_id, $share_dna,"declined");
var_dump($data);exit;*/
// share_dna  a35bcbfcaeb827c4213167e60781fd09f8a962d212860148ae0ddce135c614a5


/*$data = $app->testJoinGroup($account_id, $public_group_id);
var_dump($data);*/

/*
 * member_id :  fc52045571d1bc356cbbb5d2e736bde67f0d4765edcefcdef88c507237b20e0a
 * member_dna : dbaaa6cd346deacde042ddd23bf9407bc9f92c82b4eb63c493e2c698f7fb32b9
 */


$group_member_id = 'ba8a7e86c889e9b600a076f444acd1eb9af8d7413c93be501f2f893bf9a65c94';
$group_member_dna = '5dce24141783d5aca4d86845809aa8c3975ca689ecb5d6cd3c493e7f83940acc';

$group_member_id_decline = '5ebc99d4488cd23a8029ab5343dfefb858c6160d1cb800721539c1d32fc9e189';
$group_member_dna_decline = '5dce24141783d5aca4d86845809aa8c3975ca689ecb5d6cd3c493e7f83940acc';

/*$data=$app->getGroupMemberWhiteLists($approve_group_id);
var_dump($data);exit;*/

$member_account_id='d392e656a2759f0beb1fd2d56b2c710393e9c742b50001cd246a5dd12507d246';
$data = $app->testCreateGroupMemberWhiteLists($account_id,$member_account_id,$approve_group_id);
var_dump($data);exit;
/*
 * Group member whitelist id.    279d13a74f5cde60ae15a8fc71d06715ea2fcb866c02101c7c536cfdc04e872e
 * Group member whitelist dna.   1b253664860a3ac2eeb8d522a5c40d557db7d941c7528a7b31e7280abbc8c2e2
 */

$data=$app->testGetGroupMembers($approve_group_id);
var_dump($data);exit;

/*$data=$app->testUpdateGroupMember($group_member_dna_decline,$account_id,$approve_group_id,$group_member_id_decline);
var_dump($data);*/



/*$content_id = "edcb323b90560ae3d7822584acfa8b3843e81de43ae0a397137083f88f768382";
$share_id = "b6dbe84b872ed5fce477aa1bd1ad484e03df02fedb8516b2627d5cbf93c213a0";
$o_content_id = '25ccd4575bcbb0e76d2c67a97e7aa4c01b87f74a1be6f8d434806b350a4cee77';
$o_share_id = '3343abce95360900e05a4e695558dd14b8c960021c389bf22c3261251f0a9d28';
$data = $app->testShareToGroup($account_id, $content_id, $public_group_id,$share_id);
var_dump($data);*/

/*
 * share_id   7fd84133c36b6b6b5847a76e69a2c6fc0d533ea1919035716a64071e96000004
 */

/*
 * share_id  :  0dcaa41fab94801a782272fa8a56ef2bcf13dbad345d5ad4880a7fa553ed1be7
 */

/*
 * share_id  :  4953d9efc70c9814be331680c843b90997713f3043b7b9069e9fb721e8728502
 * share_dna :  3b3d9427478526c18dc712ab1dcbb9f193a662decfc31a3818626773979b9af9
 */







