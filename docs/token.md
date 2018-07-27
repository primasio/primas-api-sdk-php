# Primas Node API Documentation

## Token APIs


### 1. Get account tokens data

```php

$token=new \Primas\Token();

$token->getAccountTokensData(string $account_id);

```


### 2. Get incentives list


```php

$token=new \Primas\Token();

$token->getIncentivesList(string $account_id,array $parameters = []);

```


### 3. Get incentives statistics list

```php

$token=new \Primas\Token();

$token->getIncentivesStatisticsList(string $account_id,array $parameters = []);

```


### 4. Get incentives withdrawal list

```php

$token=new \Primas\Token();

$token->getIncentivesWithdrawalList(string $account_id,array $parameters = []);

```


### 5. Withdraw incentives

```php

$token=new \Primas\Token();

$token->createIncentivesWithdrawal(string $account_id,array $parameters);

```


### 6. Get token pre-lock list

```php

$token=new \Primas\Token();

$token->getPreLockTokenList(string $account_id,array $parameters = []);

```


### 7. Pre-lock tokens


```php

$token=new \Primas\Token();

$token->createPreLockTokens(string $account_id,array $transaction);

```


### 8. Unlock pre-locked tokens

**This version is not supported**

### 9. Get token lock list

```php

$token=new \Primas\Token();

$token->getLockTokensList(string $account_id,array $parameters = []);

```
