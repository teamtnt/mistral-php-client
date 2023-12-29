<?php

namespace Teamtnt\Mistral;

class Client
{
    protected $baseUrl    = 'https://api.mistral.ai/';
    protected $apiVersion = 'v1';
    protected $client;
    public function __construct($apiKey = null)
    {
        if (is_null($apiKey)) {
            throw new \Exception('API key is required');
        }

        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
            'Accept'        => 'application/json',
        ];

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'bearer'   => $apiKey,
            'headers'  => $headers,
        ]);
    }

    public function setApiVersion($version)
    {
        $this->apiVersion = $version;
    }

    public function chatStream($model, $messages, $options = [])
    {
        ob_start(); // Start output buffering

        $response = $this->client->post($this->apiVersion . '/chat/completions', [
            'json'   => [
                "model"       => $model,
                "messages"    => $messages,
                "temperature" => $options['temperature'] ?? 0.5,
                "top_p"       => $options['top_p'] ?? 1,
                "max_tokens"  => $options['max_tokens'] ?? 250,
                "stream"      => true, // Ensure streaming is enabled
                "safe_mode" => $options['safe_mode'] ?? false,
                "random_seed" => $options['random_seed'] ?? null,
            ],
            'stream' => true,
        ]);

        while (!$response->getBody()->eof()) {
            $chunk = $response->getBody()->read(1024);
            echo $chunk;
            if (ob_get_length() > 0) { // Check if there's an active output buffer
                ob_flush();
            }
            flush();
        }

    }

    public function chat($model, $messages, $options = [])
    {
        $response = $this->client->post($this->apiVersion . '/chat/completions', [
            'json' => [
                "model"       => $model,
                "messages"    => $messages,
                "temperature" => $options['temperature'] ?? 0.5,
                "top_p"       => $options['top_p'] ?? 1,
                "max_tokens"  => $options['max_tokens'] ?? 70,
                "stream"      => $options['stream'] ?? false,
                "safe_mode"   => $options['safe_mode'] ?? false,
                "random_seed" => $options['random_seed'] ?? null,
            ],
        ]);

        $array = json_decode($response->getBody(), true);
        return $array['choices'][0];
    }

    public function models()
    {
        $response = $this->client->get($this->apiVersion . '/models');
        $array    = json_decode($response->getBody(), true);

        $models = [];
        foreach ($array['data'] as $model) {
            $models[] = $model['id'];
        }

        return $models;
    }

    public function emeddings(array $input, string $model = "mistral-embed", $encoding_format = 'float')
    {
        $response = $this->client->post($this->apiVersion . '/embeddings', [
            'json' => [
                'model'    => $model,
                'input'    => $input,
                'encoding' => $encoding_format,
            ],
        ]);
        $array = json_decode($response->getBody(), true);

        $embeddings = [];
        foreach ($array['data'] as $embedding) {
            $embeddings[] = $embedding['embedding'];
        }

        return $embeddings;
    }
}
