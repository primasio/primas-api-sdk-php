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
        $content="first developer test content!!!";
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
            //"content" => "first developer test content!!!",
            "content_hash" => \Primas\Kernel\Crypto\Keccak::hash($content),
            "status" => "created"
        ];
        $metadataJson = $this->app->buildCreateContent($parameters);
        $signature = $this->app->sign($metadataJson);
        $metadata = $this->app->afterSign($metadataJson, $signature);
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
        $metadata = $this->app->afterSign($metadataJson, $signature);
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
$account_id="32fc4139f7d0347ca9ea70d30caad45a5d90fc23aaefacedf6bff2746e2073f3";
var_dump($app->testCreateImage($account_id));

