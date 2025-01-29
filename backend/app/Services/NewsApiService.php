<?php

namespace App\Services;

use GuzzleHttp\Client;

class NewsApiService
{
    protected $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function fetchArticles()
    {
        $response = $this->client->get("https://newsapi.org/v2/top-headlines", [
            'query' => [
                'apiKey'    => $this->apiKey,
                'language'  => 'en',
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // return $data['articles'] ?? [];
        return $this->formatArticles($data['articles'] ?? []);
    }

    private function formatArticles(array $articles)
    {
        return array_map(function ($article) {
            return [
                'title'         => $article['title'] ?? null,
                'description'   => $article['description'] ?? null,
                'content'       => $article['content'] ?? null,
                'url'           => $article['url'] ?? null,
                'source'        => $article['source']['name'] ?? 'Unknown Source',
                'author'        => $article['author'] ?? null,
                'published_at'  => $article['publishedAt'] ?? null,
                'image_url'     => $article['urlToImage'] ?? null,
            ];
        }, $articles);
    }
}
