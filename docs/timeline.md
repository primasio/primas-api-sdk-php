# Primas Node API Documentation

## Timeline APIs

### 1. Get account timeline

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ],
    "account_id" => $account_id
];

$app = \Primas\Factory::time_line($config);

$app->getAccountTimeline(array $parameters = []);

```

