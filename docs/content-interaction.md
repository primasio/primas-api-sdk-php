# Primas Node API Documentation

## Content Interaction APIs
In Primas, content interactions(like, comment, share) can only happen
in groups. And interactions in a given group are only visible to this group.
When interacting with content, the corresponding group id must be provided.

### 1. Get share metadata
```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->getShare(string $id, array $parameters = []);
```

### 2. Get the shares of a group share
```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->getSharesOfGroupShare(string $id, array $parameters = []);
```

### 3. Get share reports

```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->getShareReports(string $id, array $parameters = []);
```


### 4. Report share

```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->reportShare(string $id, array $parameters);
```


### 5. Get the likes of a group share

```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->getLikesOfGroupShare(string $id, array $parameters = []);
```



### 6. Like a group share

```php
$contentInteraction=new \Primas\ContentInteraction();
$contentInteraction->createLikeOfGroupShare(string $id, array $parameters);
```


### 7. Cancel the like of a group share

**This version is not supported**

### 8. Get the comments of a group share

```php
$contentInteraction->getReplyCommentsOfComments(string $id);
```


### 9. Get replying comments of a comment

```php
$contentInteraction->getCommentsOfGroupShare(string $id, array $parameters = []);
```


### 10. Comment a group share

```php
$contentInteraction->createCommentOfGroupShare(string $id, array $parameters);
```


### 11. Update the comment of a group share

**This version is not supported**


### 12. Delete the comment of a group share

**This version is not supported**