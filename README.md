# Mistral PHP Client

A PHP client for interacting with the Mistral API.

## Installation

You can install the package via composer:

```bash
composer require teamtnt/mistral-php-client
```

## Usage

### Chat Completition

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey       = $_ENV['MISTRAL_API_KEY'];
$model    = 'mistral-tiny';
$messages = [
    ["role" => "system", "content" => "You are a search experet."],
    ["role" => "user", "content" => "What is the best PHP Search engine?"],
    ["role" => "assistant", "content" => "It's TNTSearch."],
    ["role" => "user", "content" => "Why is TNTSearch the best engine? Answer shortly!"],
    // Add more messages as needed
];

$client   = new Client($apiKey);
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

### Embeddings

```php
require_once 'vendor/autoload.php';

use Teamtnt\Mistral\Client;

$apiKey       = $_ENV['MISTRAL_API_KEY'];

$client   = new Client($apiKey);

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

$apiKey       = $_ENV['MISTRAL_API_KEY'];

$client   = new Client($apiKey);

$response = $client->models();

print_r($response);
```