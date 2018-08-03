# Primas Node API Documentation

## Group APIs

### 1. Get group metadata

```php
$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::group($config);
$app->getGroupMetadata(string $group_id, array $parameters = []);
```


### 2. Create group

```php
$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::group($config);

$parameters=[
    // ....
];
$metadataJson = $app->buildCreateGroup($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadata = $app->afterSign($metadataJson);
$app->createGroup($metadata);
```


### 3. Update group

**This version is not supported**


### 4. Dismiss group

**This version is not supported**

### 5. Get group members

```php
$app->getGroupMembers(string $group_id, array $parameters = []);
```


### 6. Join group

```php
$parameters=[
    // ....
];
$metadataJson = $app->buildJoinGroup($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadata = $app->afterSign($metadataJson);
$app->joinGroup(string $group_id,$metadata);

```


### 7. Approve or decline member application

**This version is not supported**


### 8. Quit group or kick member out

**This version is not supported**


### 9. Get group member whitelist

```php
$app->getGroupMemberWhiteLists(string $group_id, array $parameters = []);
```

### 10. Add group member whitelist

```php

$parameters=[
    // ....
];
$metadataJson = $app->buildCreateGroupMemberWhiteLists($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadata = $app->afterSign($metadataJson);
$app->createGroupMemberWhiteLists(string $group_id,$metadata);

```


### 11. Approve or decline group member whitelist

**This version is not supported**


### 12. Quit group member whitelist

**This version is not supported**


### 13. Get group shares

```php
$app->getGroupShares(string $group_id, array $parameters = []);
```


### 14. Share to a group

```php
$parameters=[
    // ....
];
$metadataJson = $app->buildCreateShareToGroup($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadata = $app->afterSign($metadataJson);
$app->createShareToGroup(string $group_id,$metadata);

```

### 15. Approve or decline share application

**This version is not supported**


### 16. Delete group share

**This version is not supported**


### 17. Get group avatar metadata

```php
$app->getGroupAvatarMetadata(string $group_id);
```


### 18. Get group avatar raw image

```php
$app->getGroupAvatarRawImage(string $group_id);
```
