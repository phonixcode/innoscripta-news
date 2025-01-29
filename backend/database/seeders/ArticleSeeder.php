<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Latest Tech Trends in 2025',
                'description' => 'A look into the emerging tech trends.',
                'content' => 'Technology is advancing rapidly in 2025...',
                'url' => 'https://example.com/article-1',
                'source' => 'NewsAPI',
                'category' => 'Technology',
                'author' => 'Tech Author',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image1.jpg',
            ],
            [
                'title' => 'Health Benefits of Eating Organic',
                'description' => 'How eating organic food improves your health.',
                'content' => 'Studies show organic food helps with digestion...',
                'url' => 'https://example.com/article-2',
                'source' => 'The Guardian',
                'category' => 'Health',
                'author' => 'Health Author',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image2.jpg',
            ],
            [
                'title' => 'New Business Startups to Watch',
                'description' => 'An overview of the top startups for 2025.',
                'content' => 'New businesses are emerging in every sector...',
                'url' => 'https://example.com/article-3',
                'source' => 'BBC',
                'category' => 'Business',
                'author' => 'Business Author',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image3.jpg',
            ],
            [
                'title' => 'AI and the Future of Work',
                'description' => 'How AI is reshaping jobs and industries.',
                'content' => 'AI is expected to replace many tasks...',
                'url' => 'https://example.com/article-4',
                'source' => 'NewsAPI',
                'category' => 'Technology',
                'author' => 'AI Expert',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image4.jpg',
            ],
            [
                'title' => 'Mental Health Awareness in 2025',
                'description' => 'The importance of mental health initiatives.',
                'content' => 'Mental health is gaining more recognition...',
                'url' => 'https://example.com/article-5',
                'source' => 'The Guardian',
                'category' => 'Health',
                'author' => 'Psychology Author',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image5.jpg',
            ],
            [
                'title' => 'Top Investment Opportunities',
                'description' => 'Where to invest in 2025.',
                'content' => 'Stocks, real estate, and startups...',
                'url' => 'https://example.com/article-6',
                'source' => 'BBC',
                'category' => 'Business',
                'author' => 'Finance Guru',
                'published_at' => Carbon::now(),
                'image_url' => 'https://example.com/image6.jpg',
            ],
        ];

        // Generate additional random articles
        for ($i = 7; $i <= 20; $i++) {
            $articles[] = [
                'title' => "Article Title $i",
                'description' => "Description for article $i.",
                'content' => "Content for article $i...",
                'url' => "https://example.com/article-$i",
                'source' => ['NewsAPI', 'The Guardian', 'BBC'][array_rand(['NewsAPI', 'The Guardian', 'BBC'])],
                'category' => ['Technology', 'Health', 'Business'][array_rand(['Technology', 'Health', 'Business'])],
                'author' => "Author $i",
                'published_at' => Carbon::now(),
                'image_url' => "https://example.com/image$i.jpg",
            ];
        }

        Article::insert($articles);
    }
}
