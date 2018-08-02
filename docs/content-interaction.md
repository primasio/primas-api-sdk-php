# Primas Node API Documentation

## Content Interaction APIs
In Primas, content interactions(like, comment, share) can only happen
in groups. And interactions in a given group are only visible to this group.
When interacting with content, the corresponding group id must be provided.

### 1. Get share metadata
```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::content_interaction($config);

$app->getShare(string $share_id, array $parameters = []);
```

### 2. Get the shares of a group share
```php
$app->getSharesOfGroupShare(string $share_id, array $parameters = []);
```

### 3. Get share reports

```php
$app->getShareReports(string $share_id, array $parameters = []);
```


### 4. Report share

```php
$parameters=[
    // ....
];
$metadataJson = $app->buildReportShare($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadataJson = $app->afterSign($metadataJson);
$res = $app->reportShare(string $share_id, metadataJson);
```


### 5. Get the likes of a group share

```php
$app->getLikesOfGroupShare(string $share_id, array $parameters = []);
```



### 6. Like a group share

```php

$parameters=[
    // ....
];
$metadataJson = $app->buildCreateLikeOfGroupShare($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadataJson = $app->afterSign($metadataJson);
$res = $app->createLikeOfGroupShare(string $share_id, metadataJson);

```


### 7. Cancel the like of a group share

**This version is not supported**

### 8. Get the comments of a group share

```php
$app->getReplyCommentsOfComments(string $id);
```


### 9. Get replying comments of a comment

```php
$app->getCommentsOfGroupShare(string $id, array $parameters = []);
```


### 10. Comment a group share

```php
$parameters=[
    // ....
];
$metadataJson = $app->buildCreateCommentOfGroupShare($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadataJson = $app->afterSign($metadataJson);
$res = $app->createCommentOfGroupShare(string $share_id, metadataJson);

```


### 11. Update the comment of a group share

**This version is not supported**


### 12. Delete the comment of a group share

**This version is not supported**