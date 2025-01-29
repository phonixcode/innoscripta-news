<?php

namespace App\Utils;

use App\Models\Article;
use Carbon\Carbon;

class ArticleUtils
{
    public function saveArticles(array $articles)
    {
        foreach ($articles as $articleData) {
            $category = $this->determineCategory($articleData);
            $publishedAt = !empty($articleData['published_at'])
                ? Carbon::parse($articleData['published_at'])->toDateTimeString()
                : null;


            Article::updateOrCreate(
                [
                    'title'     => $articleData['title'],
                    'url'       => $articleData['url']
                ],
                [
                    'description'   => $articleData['description'] ?? null,
                    'content'       => $articleData['content'] ?? null,
                    'url'           => $articleData['url'],
                    'source'        => $articleData['source'],
                    'category'      => $category,
                    'author'        => $articleData['author'] ?? null,
                    'published_at'  => $publishedAt,
                    'image_url'     => $articleData['image_url'] ?? null,
                ]
            );
        }
    }

    protected function determineCategory($articleData)
    {
        $text = strtolower(($articleData['title'] ?? '') . ' ' . ($articleData['description'] ?? '') . ' ' . ($articleData['content'] ?? ''));

        foreach ($this->categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($text, strtolower($keyword)) !== false) {
                    return $category;
                }
            }
        }

        return 'General';
    }

    protected $categories = [
        'Politics'      => ['election', 'government', 'president', 'senate', 'law'],
        'Sports'        => ['football', 'soccer', 'basketball', 'tennis', 'FIFA', 'Olympics'],
        'Technology'    => ['AI', 'blockchain', 'Google', 'Microsoft', 'startup'],
        'Business'      => ['stock', 'economy', 'finance', 'investor', 'market'],
        'Health'        => ['COVID', 'vaccine', 'doctor', 'medicine', 'hospital'],
        'Entertainment' => ['movie', 'Netflix', 'celebrity', 'music', 'concert'],
    ];
}
