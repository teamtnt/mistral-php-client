<?php

use PHPUnit\Framework\TestCase;
use Teamtnt\Mistral\Client;

class ClientTest extends TestCase
{
    protected $client;
    public function setUp(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(".");
        $dotenv->load();
        $apiKey       = $_ENV['MISTRAL_API_KEY'];
        $this->client = new Client($apiKey);
    }

    public function testChat()
    {
        $messages = [
            ["role" => "system", "content" => "You are a search experet."],
            ["role" => "user", "content" => "What is the best PHP Search engine?"],
            ["role" => "assistant", "content" => "It's TNTSearch."],
            ["role" => "user", "content" => "Why is TNTSearch the best engine? Answer shortly!"],
        ];

        $response = $this->client->chat("mistral-tiny", $messages);

        $this->assertEquals(2, count($response[0]['message']));
    }

    public function testChatStream()
    {
        $messages = [
            ["role" => "system", "content" => "You are a search experet."],
            ["role" => "user", "content" => "What is the best PHP Search engine?"],
            ["role" => "assistant", "content" => "It's TNTSearch."],
            ["role" => "user", "content" => "Why is TNTSearch the best engine? Answer shortly!"],
        ];

        $this->client->chatStream("mistral-tiny", $messages);

    }
    public function testModels()
    {
        $models = $this->client->models();
        $this->assertEquals(['mistral-medium', 'mistral-small', 'mistral-tiny', 'mistral-embed'], $models);
    }

    public function testEmbeddings()
    {
        $input = [
            'First sentence.',
            'Second sentence',
        ];

        $response = $this->client->emeddings($input);

        $this->assertEquals(1024, count($response[0]));
        $this->assertEquals(1024, count($response[1]));
    }
}
