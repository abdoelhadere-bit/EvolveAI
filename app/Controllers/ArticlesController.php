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
        if (!$this->articleModel->hasGeneratedToday($userId)) {
            
            $todayPlan = $this->planModel->getTodayPlan($userId);

            if ($todayPlan) {
                $newArticles = ResponseService::generateArticlesContext($todayPlan);

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

        $articles = $this->articleModel->getAllByUserId($userId);

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

        header('Location: /EvolveAI/public/index.php?url=article/index');
        exit;
    }

    private function checkAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /EvolveAI/public/index.php?url=auth/login');
            exit;
        }
    }
}