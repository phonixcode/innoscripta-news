<?php

namespace App\Services;

use GuzzleHttp\Client;

class GuardianApiService
{
    protected $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('GUARDIAN_API_KEY');
    }

    public function fetchArticles()
    {
        $response = $this->client->get("https://content.guardianapis.com/search", [
            'query' => [
                'api-key'       => $this->apiKey,
                'show-fields'   => 'headline,trailText,body,thumbnail,byline,publication',
                'order-by'      => 'newest',
                'page-size'     => 10, 
                'lang'          => 'en'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // return $data['response']['results'] ?? [];
        return $this->formatArticles($data['response']['results'] ?? []);
    }

    private function formatArticles(array $articles)
    {
        return array_map(function ($article) {
            return [
                'title'         => $article['fields']['headline'] ?? null,
                'description'   => $article['fields']['trailText'] ?? null,
                'content'       => strip_tags($article['fields']['body'] ?? ''), 
                'url'           => $article['webUrl'] ?? null,
                'source'        => 'The Guardian',
                'author'        => $article['fields']['byline'] ?? null,
                'published_at'  => $article['webPublicationDate'] ?? null,
                'image_url'     => $article['fields']['thumbnail'] ?? null,
            ];
        }, $articles);
    }
}
