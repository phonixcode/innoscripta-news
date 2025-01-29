<?php

namespace App\Console\Commands;

use App\Utils\ArticleUtils;
use Illuminate\Console\Command;
use App\Services\NewsApiService;
use App\Services\GuardianApiService;
use App\Services\NewYorkTimesApiService;

class FetchAndSaveArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:fetch-and-save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from external APIs and save them to the database';

    protected $newsApiService;
    protected $guardianApiService;
    protected $newYorkTimesApiService;
    protected $articleUtils;

    public function __construct(
        NewsApiService $newsApiService,
        GuardianApiService $guardianApiService,
        NewYorkTimesApiService $newYorkTimesApiService,
        ArticleUtils $articleUtils
    ) {
        parent::__construct();

        $this->newsApiService = $newsApiService;
        $this->guardianApiService = $guardianApiService;
        $this->newYorkTimesApiService = $newYorkTimesApiService;
        $this->articleUtils = $articleUtils;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching articles...');

        $articles = array_merge(
            $this->newsApiService->fetchArticles(),
            $this->guardianApiService->fetchArticles(),
            $this->newYorkTimesApiService->fetchArticles()
        );

        $this->articleUtils->saveArticles($articles);

        $this->info('Articles saved successfully!');
    }
}
