<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function getArticlesWithFilters(array $filters)
    {
        $articles = Article::filter($filters)->paginate(12);
        return $articles;
    }

    public function getPersonalizedFeed($userPreferences)
    {
        return Article::query()
            ->where(function ($query) use ($userPreferences) {
                $query->orWhereIn('source', $userPreferences->sources)
                    ->orWhereIn('category', $userPreferences->categories)
                    ->orWhereIn('author', $userPreferences->authors);
            })
            ->paginate(12);
    }

}