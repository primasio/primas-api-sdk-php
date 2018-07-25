# Primas Node API Documentation

## Account APIs

### 1. Get account metadata

```php

$account=new \Primas\Account();

$account->getAccounts(string $account_id);

// sub account

$account->getAccounts(string $account_id,string $subId);

```


### 2. Create account

```php

$account=new \Primas\Account();

$account->createAccount(array $parameters);

```


### 3. Update account metadata

**This version is not supported**


### 4. Get account credits list

```php

$account=new \Primas\Account();

$account->getAccountCreditsList(string $account_id);

// sub account

$account->getSubAccountCreditsList(string $account_id,string $subId);

```


### 5. Get account content list

```php

$account=new \Primas\Account();

$account->getAccountContentList(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountContentList(string $account_id,string $subId , array $parameters = []);

```


### 6. Get account groups list

```php

$account=new \Primas\Account();

$account->getAccountGroupList(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountGroupList(string $account_id,string $subId , array $parameters = []);

```


### 7. Get account shares

```php

$account=new \Primas\Account();

$account->getAccountShares(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountShares(string $account_id,string $subId , array $parameters = []);

```


### 8. Get account shares in a single group

```php

$account=new \Primas\Account();

$account->getAccountShares(string $account_id, string $groupId, array $parameters = []);

// sub account

$account->getSubAccountSharesByGroup(string $account_id, string $subId, string $groupId, array $parameters = []);

```


### 9. Get account likes 

```php

$account=new \Primas\Account();

$account->getAccountLikes(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountLikes(string $account_id,string $subId , array $parameters = []);

```


### 10. Get account comments  


```php

$account=new \Primas\Account();

$account->getAccountComments(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountComments(string $account_id,string $subId , array $parameters = []);

```


### 11. Get account group applications

```php

$account=new \Primas\Account();

$account->getAccountGroupApplications(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountGroupApplications(string $account_id,string $subId , array $parameters = []);

```

### 12. Get account share applications

```php

$account=new \Primas\Account();

$account->getAccountShareApplications(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountShareApplications(string $account_id,string $subId , array $parameters = []);

```


### 13. Get account report list

```php

$account=new \Primas\Account();

$account->getAccountReports(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountReports(string $account_id,string $subId , array $parameters = []);

```


### 14. Get account notifications

```php

$account=new \Primas\Account();

$account->getAccountNotifications(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountNotifications(string $account_id,string $subId , array $parameters = []);

```


### 15. Get account avatar metadata

```php

$account=new \Primas\Account();

$account->getAccountAvatarMetadata(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountAvatarMetadata(string $account_id,string $subId , array $parameters = []);

```


### 16. Get account avatar raw image

```php

$account=new \Primas\Account();

$account->getAccountAvatarRaw(string $account_id , array $parameters = []);

// sub account

$account->getSubAccountAvatarRaw(string $account_id,string $subId , array $parameters = []);

```
