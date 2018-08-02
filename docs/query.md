# Primas Node API Documentation

## Query APIs

### 1. Query all APIs

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::query($config);

$app->query(array $parameters = []);

```


