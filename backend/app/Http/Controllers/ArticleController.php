<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\NewsApiService;
use App\Traits\ApiResponseTrait;
use App\Repositories\UserRepository;
use App\Services\GuardianApiService;
use App\Repositories\ArticleRepository;
use App\Services\NewYorkTimesApiService;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    protected $articleRepository;
    protected $userRepository;

    protected $newsApiService;
    protected $guardianApiService;
    protected $newYorkTimesApiService;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository $userRepository,
        NewsApiService $newsApiService,
        GuardianApiService $guardianApiService,
        NewYorkTimesApiService $newYorkTimesApiService
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->newsApiService = $newsApiService;
        $this->guardianApiService = $guardianApiService;
        $this->newYorkTimesApiService = $newYorkTimesApiService;
    }

    public function getArticles(Request $request)
    {
        $filters = $request->only('keyword', 'category', 'source', 'date');
        $articles = $this->articleRepository->getArticlesWithFilters($filters);

        return $this->successResponse($articles);
    }

    public function getPersonalizedFeed(Request $request)
    {
        $user = $request->user();
        $preferences = $this->userRepository->getPreferencesForUser($user->id);

        if (!$preferences) {
            return $this->errorResponse('No preferences found.', 404);
        }

        $articles = $this->articleRepository->getPersonalizedFeed($preferences);

        return $this->successResponse($articles);
    }

    // public function generateArticle()
    // {
    //     $articles = array_merge(
    //         $this->newsApiService->fetchArticles(),
    //         $this->guardianApiService->fetchArticles(),
    //         $this->newYorkTimesApiService->fetchArticles()
    //     );

    //     // return $articles;


    //     $this->saveArticles($articles);

    //     return response()->json(['message' => 'Articles saved successfully']);
    // }

    // protected function saveArticles(array $articles)
    // {
    //     foreach ($articles as $articleData) {
    //         $category = $this->determineCategory($articleData);
    //         $publishedAt = !empty($articleData['published_at'])
    //             ? Carbon::parse($articleData['published_at'])->toDateTimeString()
    //             : null;


    //         Article::updateOrCreate(
    //             [
    //                 'title' => $articleData['title'],
    //                 'url' => $articleData['url']
    //             ],
    //             [
    //                 'description' => $articleData['description'] ?? null,
    //                 'content' => $articleData['content'] ?? null,
    //                 'url' => $articleData['url'],
    //                 'source' => $articleData['source'],
    //                 'category' => $category,
    //                 'author' => $articleData['author'] ?? null,
    //                 'published_at' => $publishedAt,
    //                 'image_url' => $articleData['image_url'] ?? null,
    //             ]
    //         );
    //     }
    // }


    // protected function determineCategory($articleData)
    // {
    //     $text = strtolower(($articleData['title'] ?? '') . ' ' . ($articleData['description'] ?? '') . ' ' . ($articleData['content'] ?? ''));

    //     foreach ($this->categories as $category => $keywords) {
    //         foreach ($keywords as $keyword) {
    //             if (strpos($text, strtolower($keyword)) !== false) {
    //                 return $category;
    //             }
    //         }
    //     }

    //     return 'General';
    // }

    // protected $categories = [
    //     'Politics' => ['election', 'government', 'president', 'senate', 'law'],
    //     'Sports' => ['football', 'soccer', 'basketball', 'tennis', 'FIFA', 'Olympics'],
    //     'Technology' => ['AI', 'blockchain', 'Google', 'Microsoft', 'startup'],
    //     'Business' => ['stock', 'economy', 'finance', 'investor', 'market'],
    //     'Health' => ['COVID', 'vaccine', 'doctor', 'medicine', 'hospital'],
    //     'Entertainment' => ['movie', 'Netflix', 'celebrity', 'music', 'concert'],
    // ];

}
