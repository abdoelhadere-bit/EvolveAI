<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\DailyPlanModel;
use App\Services\ResponseService;

final class ArticlesController
{
    private ArticleModel $articleModel;
    private DailyPlanModel $planModel;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
        $this->planModel = new DailyPlanModel();
    }

    public function getIndex(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        // 1. AUTO-GENERATION LOGIC
        // Check if we already have articles for today. If NOT, try to generate them.
        if (!$this->articleModel->hasGeneratedToday($userId)) {
            
            // Get today's plan to use as context
            $todayPlan = $this->planModel->getTodayPlan($userId);

            if ($todayPlan) {
                // Call AI to generate 2 articles based on the plan
                $newArticles = ResponseService::generateArticlesContext($todayPlan);

                // Save them to DB
                foreach ($newArticles as $article) {
                    $this->articleModel->create(
                        $userId,
                        $article['title'] ?? 'Daily Insight',
                        $article['content'] ?? 'No content provided.',
                        $article['links'] ?? ''
                    );
                }
            }
        }

        // 2. Fetch all articles (New & Old)
        $articles = $this->articleModel->getAllByUserId($userId);

        // 3. Render View
        require __DIR__ . '/../Views/dashboard/articles.php';
    }

    public function postDelete(): void
    {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleId = (int) ($_POST['article_id'] ?? 0);
            $userId = (int) $_SESSION['user_id'];
            
            if ($articleId) {
                $this->articleModel->delete($articleId, $userId);
            }
        }

        header('Location: /EvolveAi/articles');
        exit;
    }

    private function checkAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /EvolveAi/login');
            exit;
        }
    }
}