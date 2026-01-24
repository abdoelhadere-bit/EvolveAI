<?php

namespace App\Controllers;

use App\Models\FeedbackModel;
use App\Models\DailyPlanModel;
use App\Services\ResponseService;

final class FeedbackController
{
    private FeedbackModel $feedbackModel;
    private DailyPlanModel $planModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
        $this->planModel = new DailyPlanModel();
    }

    public function getIndex(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        // Get History of Feedback
        $history = $this->feedbackModel->getHistory($userId);

        require __DIR__ . '/../Views/dashboard/feedback.php';
    }

    public function postSubmit(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskTitle = $_POST['task_title'] ?? 'General Task';
            $userWork = $_POST['user_work'] ?? '';

            if (!empty($userWork)) {
                // 1. Get Context (Today's Plan)
                $planHtml = $this->planModel->getTodayPlan($userId) ?? 'No plan context';

                // 2. Analyze with AI
                $analysis = ResponseService::analyzeTaskSubmission($planHtml, $taskTitle, $userWork);

                // 3. Save Result
                try {
                    $this->feedbackModel->saveSubmission($userId, $taskTitle, $userWork, $analysis);
                } catch (\Throwable $e) {
                    // Log error
                }
            }
        }

        header('Location: /EvolveAi/feedback');
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