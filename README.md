# Mistral PHP Client

A PHP client for interacting with the Mistral API.

## Installation

You can install the package via composer:

```bash
composer require teamtnt/mistral-php-client
```

## Usage

Our package provides a wide range of features, including streaming support to boost your application's performance. To help you get started, we've provided practical examples that demonstrate how to use the package effectively. For an in-depth understanding of all available parameters and their specific usage, please refer to the [Mistral API documentation](https://docs.mistral.ai/api/).

### Chat Completition

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey = $_ENV['MISTRAL_API_KEY'];

$model = 'mistral-tiny';

$messages = [
    ["role" => "system", "content" => "You are a search experet."],
    ["role" => "user", "content" => "What is the best PHP Search engine?"],
    ["role" => "assistant", "content" => "It's TNTSearch."],
    ["role" => "user", "content" => "Why is TNTSearch the best engine? Answer shortly!"],
    // Add more messages as needed
];

$client = new Client($apiKey);

$response = $client->chat($model, $messages, [
    'temperature' => 0.5,
    'top_p'       => 1,
    'max_tokens'  => 250,
    'safe_mode'   => false,
    'random_seed' => null,
]);

print_r($response);
```

You can also emmit the options arugument and use it like:

```php

$response = $client->chat($model, $messages);

print_r($response);
```

### Chat Completition with streaming

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey = $_ENV['MISTRAL_API_KEY'];

$model = 'mistral-tiny';

$messages = [
    ["role" => "system", "content" => "You are a search expert."],
    ["role" => "user", "content" => "Why is TNTSearch the best engine?"],
    // Add more messages as needed
];

$client = new Client($apiKey);

$response = $client->chat($model, $messages, [
    'temperature' => 0.0,
    'top_p'       => 1,
    'max_tokens'  => 250,
    'safe_mode'   => false,
    'random_seed' => null,
]);

print_r($response);
```

### Embeddings

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey = $_ENV['MISTRAL_API_KEY'];

$client = new Client($apiKey);

$input = [
    'First sentence.',
    'Second sentence',
];

$response = $client->emeddings($input);

print_r($response);
```

### Available Models

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey = $_ENV['MISTRAL_API_KEY'];

$client = new Client($apiKey);

$response = $client->models();

print_r($response);
```