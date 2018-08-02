# Primas Node API Documentation

## Node APIs

### 1. Get node list

```php

$config = [
    "http_options" => [
        "base_uri" => "https://staging.primas.io"      // testnet
    ]
];

$app = \Primas\Factory::node($config);

$app->getNodeLists(array $parameters = []);

```