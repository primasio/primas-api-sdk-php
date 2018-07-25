# Primas SDK of PHP (v3)

* Primas Node API Documentation [https://github.com/primasio/primas-api-doc](https://github.com/primasio/primas-api-doc)

## Translations

- [English Document](README-en.md)

## 依赖

```
 "php-64bit": ">=7.0",
 "ext-gmp": "*",
 "ext-scrypt": "~1.4",
 "ext-secp256k1": ">=0.1.0",
 "ext-keccak": "~0.2",
 "guzzlehttp/guzzle": "~6.0",
 "bitwasp/buffertools": "^0.5.0"
```

* ext-scrypt: [https://github.com/DomBlack/php-scrypt](https://github.com/DomBlack/php-scrypt)
* ext-secp256k1: [https://github.com/Bit-Wasp/secp256k1-php](https://github.com/Bit-Wasp/secp256k1-php)
* ext-keccak: [https://github.com/archwisp/php-keccak-hash](https://github.com/archwisp/php-keccak-hash)

### 安装

* composer require ...

### 快速使用
* 注意:使用API方法之前需初始化API配置

**不需要进行签名操作**
```php
// 如果不进行签名操作
\Primas\Primas::init([

    /*
     * (string|UriInterface) 基URI用来合并到相关URI，可以是一个字符串或者UriInterface的实例，当提供了相关uri，将合并到基URI
     */
    "base_uri" => "https://staging.primas.io",
    /*
     * 请求时验证SSL证书行为。
     * 设置成 true 启用SSL证书验证，默认使用操作系统提供的CA包。
     * 设置成 false 禁用证书验证(这是不安全的！)。
     * 设置成字符串启用验证，并使用该字符串作为自定义证书CA包的路径。
     * @var bool|string
     * @default true
     */
    "verify" => true
]);
```
**需要进行签名操作**
```php
/*
 * $privateKey 为 \Primas\Types\Byte实例化的对象
 */

\Primas\Primas::init($options, $privateKey);

// 如何获取 $privateKey ?
// 1. 通过keystore获取
/*
 * 密码需和keystore对应,否则会抛异常
 */
$keyStore = '{"version":3,"id":"e1a1909a-7a38-44aa-af04-61cd3a342008","address":"d75407ad8cabeeebfed78c4f3794208b3339fbf4","Crypto":{"ciphertext":"bcf8d3037432f731d3dbb0fde1b32be47faa202936c303ece7f53890a79f49d2","cipherparams":{"iv":"e28edaeff90032f24481c6117e593e01"},"cipher":"aes-128-ctr","kdf":"scrypt","kdfparams":{"dklen":32,"salt":"7d7c824367d7f6607128c721d6e1729abf706a3165384bbfc2aae80510ec0ce2","n":1024,"r":8,"p":1},"mac":"52f98caaa4959448ec612e4314146b6a2d5022d5394b77e31f5a79780079c22f"}}';
$password = "Test123:::";
$keyStore = new \Primas\Keystore($keyStore, $password);
$privateKey = $keyStore->getPrivateKey();
$publicKey = $keyStore->getPublicKey();
$address = $keyStore->getAddress();

// 2. 自定义私钥
// 需为16进制64长度的字符串
$hex = "abcdef0123456789abcdef0123456789abcdef0123456789abcdef0123456789";
$privateKey = \Primas\Types\Byte::initWithHex($hex);

// 初始化API配置
\Primas\Primas::init([
    "base_uri" => "https://staging.primas.io",
    "verify" => true
], $privateKey);
```

### API List

- [Content APIs](./content.md#content-apis)
  * [Content Licensing](./content.md#content-licensing)
  * [Content Format](./content.md#content-format)
  * [1. Get content metadata](./content.md#1-get-content-metadata)
  * [2. Get raw content](./content.md#2-get-raw-content)
  * [3. Post content](./content.md#3-post-content)
  * [4. Update content](./content.md#4-update-content)
- [Content Interaction APIs](./content-interaction.md#content-interaction-apis)
  * [1. Get share metadata](./content-interaction.md#1-get-share-metadata)
  * [2. Get the shares of a group share](./content-interaction.md#2-get-the-shares-of-a-group-share)
  * [3. Get share reports](./content-interaction.md#3-get-share-reports)
  * [4. Report share](./content-interaction.md#4-report-share)
  * [5. Get the likes of a group share](./content-interaction.md#5-get-the-likes-of-a-group-share)
  * [6. Like a group share](./content-interaction.md#6-like-a-group-share)
  * [7. Cancel the like of a group share](./content-interaction.md#7-cancel-the-like-of-a-group-share)
  * [8. Get the comments of a group share](./content-interaction.md#8-get-the-comments-of-a-group-share)
  * [9. Get replying comments of a comment](./content-interaction.md#9-get-replying-comments-of-a-comment)
  * [10. Comment a group share](./content-interaction.md#10-comment-a-group-share)
  * [11. Update the comment of a group share](./content-interaction.md#11-update-the-comment-of-a-group-share)
  * [12. Delete the comment of a group share](./content-interaction.md#12-delete-the-comment-of-a-group-share)
- [Group APIs](./group.md#group-apis)
  * [1. Get group metadata](./group.md#1-get-group-metadata)
  * [2. Create group](./group.md#2-create-group)
  * [3. Update group](./group.md#3-update-group)
  * [4. Dismiss group](./group.md#4-dismiss-group)
  * [5. Get group members](./group.md#5-get-group-members)
  * [6. Join group](./group.md#6-join-group)
  * [7. Approve or decline member application](./group.md#7-approve-or-decline-member-application)
  * [8. Quit group or kick member out](./group.md#8-quit-group-or-kick-member-out)
  * [9. Get group member whitelist](./group.md#9-get-group-member-whitelist)
  * [10. Add group member whitelist](./group.md#10-add-group-member-whitelist)
  * [11. Approve or decline group member whitelist](./group.md#11-approve-or-decline-group-member-whitelist)
  * [12. Quit group member whitelist](./group.md#12-quit-group-member-whitelist)
  * [13. Get group shares](./group.md#13-get-group-shares)
  * [14. Share to a group](./group.md#14-share-to-a-group)
  * [15. Approve or decline share application](./group.md#15-approve-or-decline-share-application)
  * [16. Delete group share](./group.md#16-delete-group-share)
  * [17. Get group avatar metadata](./group.md#17-get-group-avatar-metadata)
  * [18. Get group avatar raw image](./group.md#18-get-group-avatar-raw-image)
- [Account APIs](./account.md#account-apis)
  * [1. Get account metadata](./account.md#1-get-account-metadata)
  * [2. Create account](./account.md#2-create-account)
  * [3. Update account metadata](./account.md#3-update-account-metadata)
  * [4. Get account credits list](./account.md#4-get-account-credits-list)
  * [5. Get account content list](./account.md#5-get-account-content-list)
  * [6. Get account groups list](./account.md#6-get-account-groups-list)
  * [7. Get account shares](./account.md#7-get-account-shares)
  * [8. Get account shares in a single group](./account.md#8-get-account-shares-in-a-single-group)
  * [9. Get account likes](./account.md#9-get-account-likes)
  * [10. Get account comments](./account.md#10-get-account-comments)
  * [11. Get account group applications](./account.md#11-get-account-group-applications)
  * [12. Get account share applications](./account.md#12-get-account-share-applications)
  * [13. Get account report list](./account.md#13-get-account-report-list)
  * [14. Get account notifications](./account.md#14-get-account-notifications)
  * [15. Get account avatar metadata](./account.md#15-get-account-avatar-metadata)
  * [16. Get account avatar raw image](./account.md#16-get-account-avatar-raw-image)
- [Token APIs](./token.md#token-apis)
  * [1. Get account tokens data](./token.md#1-get-account-tokens-data)
  * [2. Get incentives list](./token.md#2-get-incentives-list)
  * [3. Get incentives statistics list](./token.md#3-get-incentives-statistics-list)
  * [4. Get incentives withdrawal list](./token.md#4-get-incentives-withdrawal-list)
  * [5. Withdraw incentives](./token.md#5-withdraw-incentives)
  * [6. Get token pre-lock list](./token.md#6-get-token-pre-lock-list)
  * [7. Pre-lock tokens](./token.md#7-pre-lock-tokens)
  * [8. Unlock pre-locked tokens](./token.md#8-unlock-pre-locked-tokens)
  * [9. Get token lock list](./token.md#9-get-token-lock-list)
- [Timeline APIs](./timeline.md#timeline-apis)
  * [1. Get account timeline](./timeline.md#1-get-account-timeline)
- [Query APIs](./query.md#query-apis)
  * [1. Query all APIs](./query.md#1-query-all-apis)
- [System APIs](./system.md#system-apis)
  * [1. Get system parameters](./system.md#1-get-system-parameters)
- [Node APIs](./node.md#node-apis)
  * [1. Get node list](./node.md#1-get-node-list)

### Error Code and Troubleshooting

| result_code	| result_msg | description |
| ------------ | ------------- | ------------- |
| 0	| success | Success|
| 400 | client error | Client error|
| 401	| invalid data | Invalid post data |
| 402 | parse input JSON format error | Invalid JSON string |
| 403 | client signature error | Signature verification failed |
| 404	| input parameter error | Invalid parameter |
| 405	| input parameter empty | Empty parameter |
| 406	| nonce less than lasted | Nonce is used before |
| 500	| server error | Server error |