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
                $planHtml = $this->planModel->getTodayPlan($userId) ?? 'No plan context';

                $analysis = ResponseService::analyzeTaskSubmission($planHtml, $taskTitle, $userWork);

                try {
                    $this->feedbackModel->saveSubmission($userId, $taskTitle, $userWork, $analysis);
                } catch (\Throwable $e) {
                }
            }
        }

        header('Location: /EvolveAI/public/index.php?url=feedback/index');
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