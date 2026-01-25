<?php

namespace App\Controllers;

use App\Models\ResponseModel;
use App\Models\DailyPlanModel;
use App\Services\ResponseService;

final class ResponseController
{
    public function getGenerate(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        $responseModel = new ResponseModel();
        $answers = $responseModel->getAnswersByUserId($userId);

        if (!$answers) {
            header('Location: /EvolveAI/public/index.php?url=/questionaire/view');
            exit;
        }

        // Filter tokens
        $meaningfulAnswers = array_filter(
            $answers, 
            fn($k) => !in_array($k, ['csrf_token', 'submit', '_token']), 
            ARRAY_FILTER_USE_KEY
        );

        // Generate Opportunities 
        $opportunities = ResponseService::generateOpportunities($meaningfulAnswers);

        // Render Selection View
        require __DIR__ . '/../Views/dashboard/opportunities.php';
    }

    // Detailed Plan
    public function postPlan(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        $planModel = new DailyPlanModel();
        
        // Calculate Day Number 
        $historyCount = $planModel->getPlanCount($userId);
        $currentDay = $historyCount + 1;

        // Capture Form Data
        $selectedOpportunity = [
            'title' => $_POST['opportunity_title'] ?? 'Selected Opportunity',
            'description' => $_POST['opportunity_desc'] ?? '',
            'earnings' => $_POST['opportunity_earnings'] ?? '',
            'context' => $_POST['opportunity_context'] ?? ''
        ];

        // Generate Dynamic Plan
        $tasks = ResponseService::generateExecutionPlan($selectedOpportunity, $currentDay);

        // Save Structured Plan
        $planModel->saveTodayPlan($userId, $tasks, $currentDay);

        header('Location: /EvolveAI/public/index.php?url=dashboard/view');
        exit;
    }

    private function checkAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            exit('Unauthorized');
        }
    }
}