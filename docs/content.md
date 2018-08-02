# Primas Node API Documentation

## Content APIs

Content(articles and images) related APIs. Posting and reading content.

### Content Licensing

When posting, the author could attach a license to the content
to describe how the content could be used or disseminated.

DTCP supports the register of all kinds of licenses while in Primas however,
only 2 types of standard license is currently supported. 

There's a widely used license for freely content sharing
called [Creative Commons](https://creativecommons.org/), or CC in short,
which has a combination of different parameters to fully customize the way
content can be shared.

Primas supports CC 4.0 by filling "cc" in the `license.name` field.
Different options can also be specified in the `license.parameters` field.

```
{
  "name": "cc",
  "version": "4.0",
  "parameters": [
    {
      "name": "derivative",     // Whether Derivation is allowed.
      "value": "y"              // "y", "n" or "sa" for share-alike
    },
    {
      "name": "commercial",     // Whether commercial usage is allowed
      "value": "n"              // "y" or "n"
    }
  ]
}
``` 

Beside CC license, Primas supports commercial license as well, which allows the author
to set a price on the authorization of the content:

```
{
  "name": "commercial",
  "version": "2.0",
  "parameters": [
    {
      "name": "derivative",     // Whether Derivation is allowed.
      "value": "y"              // "y", "n"
    },
    {
      "name": "currency",       // Currency used for payment
      "value": "PST"            // Only PST is supported in Primas network
    },
    {
      "name": "price",
      "value": 100
    }
  ]
}
``` 

### Content Format

### 1. Get content metadata

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::content($config);

$content_id="1GFYUNP815RUIFDNNRKLNU78RPCFLNL5DWGT7EXODHFVRCRVXJ";

$app->getContent($content_id);
```

### 2. Get raw content

```php
$app->getRawContent(string $content_id);
```

### 3. Post content

```php
$parameters=[
    // ....
];
$metadataJson = $app->buildCreateAccount($parameters);
// with keystore
$signature = $app->sign($metadataJson);
// with signature machine
$signature = "your signature from signature machin";
$metadataJson = $app->afterSign($metadataJson);
$createRes = $app->createContent($metadataJson);

```


### 4. Update content

**This version is not supported**






