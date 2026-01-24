<?php

namespace App\Controllers;

use App\Models\ResponseModel;
use App\Models\DailyPlanModel;
use App\Services\ResponseService;

final class ResponseController
{
    // 1. Grid of Opportunities
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

        // Generate Grid
        $html = ResponseService::generateOpportunities($meaningfulAnswers);

        // Save
        $planModel = new DailyPlanModel();
        $planModel->saveTodayPlan($userId, $html);

        header('Location: /EvolveAI/public/index.php?url=dashboard/view');
        exit;
    }

    // 2. Detailed Plan (Dynamic Day Logic)
    public function postPlan(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        $planModel = new DailyPlanModel();
        
        // A. Get existing Grid (to append later)
        $opportunitiesHtml = $planModel->getTodayPlan($userId);

        // B. Calculate Day Number (The "Evolution" Logic)
        // We count total previous plans. If 0 exist, today is Day 1.
        // We add +1 because we are creating the *current* day's plan.
        $historyCount = $planModel->getPlanCount($userId);
        $currentDay = $historyCount + 1;

        // C. Capture Form Data
        $selectedOpportunity = [
            'title' => $_POST['opportunity_title'] ?? 'Selected Opportunity',
            'description' => $_POST['opportunity_desc'] ?? '',
            'context' => $_POST['opportunity_context'] ?? ''
        ];

        // D. Generate Dynamic Plan
        $planHtml = ResponseService::generateExecutionPlan($selectedOpportunity, $currentDay);

        // E. Merge (Plan on top, Opportunities below)
        if ($opportunitiesHtml) {
            $finalHtml = $this->mergeHtml($planHtml, $opportunitiesHtml);
        } else {
            $finalHtml = $planHtml;
        }

        $planModel->saveTodayPlan($userId, $finalHtml);

        header('Location: /EvolveAI/public/index.php?url=dashboard/view');
        exit;
    }

    private function mergeHtml(string $topHtml, string $bottomHtml): string
    {
        // Simple divider
        $divider = '<div class="my-12 border-t border-gray-200 text-center"><span class="bg-gray-50 px-3 text-gray-500 text-sm relative -top-3">Explore Other Paths</span></div>';
        
        // Since we are using partial HTML (no body tags), we can just concatenate
        return $topHtml . $divider . $bottomHtml;
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