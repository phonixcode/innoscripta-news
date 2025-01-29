<?php

namespace App\Services;

use GuzzleHttp\Client;

class NewYorkTimesApiService
{
    protected Client $client;
    protected string $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('NYT_API_KEY'); 
    }

    public function fetchArticles(): array
    {
        $response = $this->client->get("https://api.nytimes.com/svc/topstories/v2/home.json", [
            'query' => [
                'api-key' => $this->apiKey,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // return $data['results'] ?? [];
        return $this->formatArticles($data['results'] ?? []);
    }

    private function formatArticles(array $articles): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['title'] ?? null,
                'description' => $article['abstract'] ?? null,
                'content' => $article['short_url'] ?? null, 
                'url' => $article['url'] ?? null,
                'source' => 'New York Times',  
                'author' => $article['byline'] ?? null,
                'published_at' => $article['published_date'] ?? null,
                'image_url' => $article['multimedia'][0]['url'] ?? null, 
            ];
        }, $articles);
    }
}
