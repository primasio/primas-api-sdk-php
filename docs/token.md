# Primas Node API Documentation

## Token APIs


### 1. Get account tokens data

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ],
    "account_id" => $account_id
];

$app = \Primas\Factory::token($config);

$app->getAccountTokensData();

```


### 2. Get incentives list


```php

$app->getIncentivesList(array $parameters = []);

```


### 3. Get incentives statistics list

```php

$app->getIncentivesStatisticsList(array $parameters = []);

```


### 4. Get incentives withdrawal list

```php

$app->getIncentivesWithdrawalList(array $parameters = []);

```


### 5. Withdraw incentives

```php

$parameters=[
    // ....
];
$metadataJson = $app->buildCreateIncentivesWithdrawal($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadata = $app->setSignature($metadataJson);
$app->createIncentivesWithdrawal($metadata);

```


### 6. Get token pre-lock list

```php

$app->getPreLockTokenList(array $parameters = []);

```


### 7. Pre-lock tokens


```php

  // your account address
        $address = '0x2cbca948ef67f917ceadce8c685faf301bfe44cc';
        $parameters = [
            "amount"=> 120 ,                                      // Pre lock amount , type integer
            // you can use package ramsey/uuid to generate
            "nonce" => "e0926af4e73e496cb2c4d745389e9431",        //  the 32-bit uuid
            "address" => $address,                                // user account address
        ];
        $metadataJson = $this->app->buildTransaction($parameters);
        $sign = $this->app->sign($metadataJson);
        // Prelocking is different from other interfaces
        $data = $this->app->createPreLockTokens($parameters,$sign);
        return $data;


```


### 8. Unlock pre-locked tokens

**This version is not supported**

### 9. Get token lock list

```php

$app->getLockTokensList(array $parameters = []);

```
