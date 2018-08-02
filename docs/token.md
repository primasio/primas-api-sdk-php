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
$metadataJson = $app->afterSign($metadataJson);
$app->createIncentivesWithdrawal($metadataJson);

```


### 6. Get token pre-lock list

```php

$app->getPreLockTokenList(array $parameters = []);

```


### 7. Pre-lock tokens


```php

$app->createPreLockTokens(array $transaction);

```


### 8. Unlock pre-locked tokens

**This version is not supported**

### 9. Get token lock list

```php

$app->getLockTokensList(array $parameters = []);

```
