# Primas Node API Documentation

## System APIs

### 1. Get system parameters

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::system($config);

$app->getSystemParameters();

```
