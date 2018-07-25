# Primas Node API Documentation

## Group APIs

### 1. Get group metadata

```php
$group=new \Primas\Group();
$group->getGroupMetadata(string $group_id, array $parameters = []);
```


### 2. Create group

```php
$group=new \Primas\Group();
$group->createGroup(array $parameters);
```


### 3. Update group

**This version is not supported**


### 4. Dismiss group

**This version is not supported**

### 5. Get group members

```php
$group->getGroupMembers(string $group_id, array $parameters = []);
```


### 6. Join group

```php
$group->createGroup(string $group_id,array $parameters);
```


### 7. Approve or decline member application

**This version is not supported**


### 8. Quit group or kick member out

**This version is not supported**


### 9. Get group member whitelist

```php
$group->getGroupMemberWhiteLists(string $group_id, array $parameters = []);
```

### 10. Add group member whitelist

```php
$group->createGroupMemberWhiteLists(string $group_id,array $parameters);
```


### 11. Approve or decline group member whitelist

**This version is not supported**


### 12. Quit group member whitelist

**This version is not supported**


### 13. Get group shares

```php
$group->getGroupShares(string $group_id, array $parameters = []);
```


### 14. Share to a group

```php
$group->createShareToGroup(string $group_id,array $parameters);
```

### 15. Approve or decline share application

**This version is not supported**


### 16. Delete group share

**This version is not supported**


### 17. Get group avatar metadata

```php
$group->getGroupAvatarMetadata(string $group_id);
```


### 18. Get group avatar raw image

```php
$group->getGroupAvatarRawImage(string $group_id);
```
