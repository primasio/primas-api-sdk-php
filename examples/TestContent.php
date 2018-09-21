<?php

include "init.php";

class TestContent extends TestBase {

    public function __construct()
    {
        $config = [
            "http_options" => [
                "base_uri" => BASE_URI,
                /*"headers" => [
                    "Content-Type" => "application/x-www-form-urlencoded"
                ]*/
                /*"headers" => [
                    "Content-Type" => "multipart/form-data"
                ]*/

            ],
            // "account_id" => $account_id
        ];
        $this->app = \Primas\Factory::content($config);
    }

    public function testCreateArticle($account_id){
        // create
        $content='<h1 data-v-13f76525="" class="article-title">2018年最值得关注学习的25个JavaScript开源项目</h1>';
        $parameters = [
            "version" => "1.0",
            "type" => "object",
            "tag" => "article",
            "title" => "content test",
            "creator" => json_encode([
                "account_id" => $account_id
            ]),
            "abstract" => "abstract",
            "language" => "en-US",
            "category" => "test",
            "created" => time(),
            "content" => $content,
            "content_hash" => \Primas\Kernel\Crypto\Keccak::hash($content),
            "status" => "created"
        ];
        $metadataJson = $this->app->buildCreateContent($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        $parameters["content"] = $content;
        $createRes = $this->app->createContent($metadata,$parameters);
        return $createRes;
    }

    /**
     * you can get $content_id from testCreateArticle
     *
     * @param $content_id
     */
    public function testGetContent($content_id){
        return $this->app->getContent($content_id);
    }

    public function testCreateImage($account_id){
        $testImage = __DIR__ . "/images/test.png";
        $handle = fopen($testImage, "r");
        $content = fread($handle, filesize($testImage));
        fclose($handle);
        $parameters = [
            "version" => "1.0",
            "type" => "object",
            "tag" => "image",
            "title" => "content test",
            "creator" => json_encode([
                "account_id" => $account_id
            ]),
            "abstract" => "abstract",
            "language" => "en-US",
            "category" => "test",
            "created" => 1534161372,
            //"content" => $content,      // The signature does not check content
            "content_hash" => \Primas\Kernel\Crypto\Keccak::hash($content),
            "status" => "created"
        ];
        $metadataJson = $this->app->buildCreateContent($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->setSignature($metadataJson, $signature);
        // when Content-Type:application/json or application/x-www-form-urlencoded
        $parameters["content"] = $content;
        /*
         *  when Content-Type:multipart/form-data  content should be a file path like "F:/tmp/test.png" or an object instance CURLFile
         *  $parameters["content"] = new CURLFile($testImage);
         */
        $createRes = $this->app->createContent($metadata, $parameters);
        return $createRes;
    }

    /**
     * get image
     *
     * @param $content_id
     */
    public function testGetRawContent($content_id){
        $rawContent = $this->app->getRawContent($content_id);
        return $rawContent;
    }
}

$app = new TestContent();
$account_id="e89c51db3e8b1130944a1d98308ec101d0c01cce3407e2d3d5d71e7f19e5dea9";
//var_dump($app->testCreateImage($account_id));

var_dump($app->testCreateArticle($account_id));


