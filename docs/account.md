# Primas Node API Documentation

## Account APIs

### 1. Get account metadata

```php

$base_uri="https://staging.primas.io";  //test

$account_id = "809a85f7ddf8ae5aaa49fe30be10e07e09156dc04166fab98bbd7bb42b2dc26c";
$config = [
    "http_options" => [
        "base_uri" => $base_uri
    ],
    "account_id" => $account_id
];
$app = \Primas\Factory::account($config);
$app->getAccounts();

// sub account

$app->getSubAccounts(string $subId);

```


### 2. Create account

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::account($config);


// Sign with the keystore

// Import the keystore
$keystore = '{"version":3,"id":"e1a1909a-7a38-44aa-af04-61cd3a342008","address":"d75407ad8cabeeebfed78c4f3794208b3339fbf4","Crypto":{"ciphertext":"bcf8d3037432f731d3dbb0fde1b32be47faa202936c303ece7f53890a79f49d2","cipherparams":{"iv":"e28edaeff90032f24481c6117e593e01"},"cipher":"aes-128-ctr","kdf":"scrypt","kdfparams":{"dklen":32,"salt":"7d7c824367d7f6607128c721d6e1729abf706a3165384bbfc2aae80510ec0ce2","n":1024,"r":8,"p":1},"mac":"52f98caaa4959448ec612e4314146b6a2d5022d5394b77e31f5a79780079c22f"}}';
$password = "Test123:::";
\Primas\Kernel\Eth\Keystore::init($keyStore, $password);

$parameters = [
    "name" => "Test123",
    "abstract" => "first test",
    "created" => time(),
    "address" => (string)\Primas\Kernel\Eth\Keystore::getAddress();
];

$metadataJson = $app->buildCreateAccount($parameters);

$signature = $app->sign($metadataJson);

$metadataJson = $app->afterSign($metadataJson, $signature);

$res = $app->createAccount($metadataJson);


// ......

// Sign with a signature machine

$parameters = [
    "name" => "Test123",
    "abstract" => "first test",
    "created" => time(),
    "address" => "0xd75407ad8cabeeebfed78c4f3794208";
];

$metadataJson = $app->buildCreateAccount($parameters);

// TODO request signature machine get signature
// If it is asynchronous, save the correspondence between the signature result and the application.

$signature="";

$metadataJson = $app->afterSign($metadataJson, $signature);

$res = $app->createAccount($metadataJson);

var_dump($res);

// save the root account id
// save the root account id
// save the root account id

// result
/*
 array(3) {
  ["result_code"]=>
  int(0)
  ["result_msg"]=>
  string(7) "success"
  ["data"]=>
  array(2) {
    ["id"]=>
    string(64) "e19aa9a8cdc217c345925b7e824baea0ef6dab0e11117dfd2746be469b412724"
    ["dna"]=>
    string(64) "4659b4848c8e9e3ec60c94ded2cc58a35419411f58ff27dc51f116bb05577eb9"
  }
}
*/

```


### 3. Update account metadata

**This version is not supported**


### 4. Get account credits list

```php

$app = \Primas\Factory::account($config);

$app->getAccountCreditsList();

// sub account

$app->getSubAccountCreditsList(string $subId);

```


### 5. Get account content list

```php

$app = \Primas\Factory::account($config);

$app->getAccountContentList(array $parameters = []);

// sub account

$app->getSubAccountContentList(string $subId , array $parameters = []);

```


### 6. Get account groups list

```php

$app = \Primas\Factory::account($config);

$app->getAccountGroupList(array $parameters = []);

// sub account

$app->getSubAccountGroupList(string $subId , array $parameters = []);

```


### 7. Get account shares

```php

$app = \Primas\Factory::account($config);

$app->getAccountShares(array $parameters = []);

// sub account

$app->getSubAccountShares(string $subId , array $parameters = []);

```


### 8. Get account shares in a single group

```php

$app = \Primas\Factory::account($config);

$app->getAccountShares( string $groupId, array $parameters = []);

// sub account

$app->getSubAccountSharesByGroup( string $subId, string $groupId, array $parameters = []);

```


### 9. Get account likes 

```php

$app = \Primas\Factory::account($config);

$app->getAccountLikes(array $parameters = []);

// sub account

$app->getSubAccountLikes(string $subId , array $parameters = []);

```


### 10. Get account comments  


```php

$app = \Primas\Factory::account($config);

$app->getAccountComments(array $parameters = []);

// sub account

$app->getSubAccountComments(string $subId , array $parameters = []);

```


### 11. Get account group applications

```php

$app = \Primas\Factory::account($config);

$app->getAccountGroupApplications(array $parameters = []);

// sub account

$app->getSubAccountGroupApplications(string $subId , array $parameters = []);

```

### 12. Get account share applications

```php

$app = \Primas\Factory::account($config);

$app->getAccountShareApplications(array $parameters = []);

// sub account

$app->getSubAccountShareApplications(string $subId , array $parameters = []);

```


### 13. Get account report list

```php

$app = \Primas\Factory::account($config);

$app->getAccountReports(array $parameters = []);

// sub account

$app->getSubAccountReports(string $subId , array $parameters = []);

```


### 14. Get account notifications

```php

$app = \Primas\Factory::account($config);

$app->getAccountNotifications(array $parameters = []);

// sub account

$app->getSubAccountNotifications(string $subId , array $parameters = []);

```


### 15. Get account avatar metadata

```php

$app = \Primas\Factory::account($config);

$app->getAccountAvatarMetadata(array $parameters = []);

// sub account

$app->getSubAccountAvatarMetadata(string $subId , array $parameters = []);

```


### 16. Get account avatar raw image

```php

$app = \Primas\Factory::account($config);

$app->getAccountAvatarRaw(array $parameters = []);

// sub account

$app->getSubAccountAvatarRaw(string $subId , array $parameters = []);

```
