<?php

namespace App\Controllers;

use App\Models\ResponseModel;
use App\Models\DailyPlanModel;
use App\Services\ResponseService;

final class ResponseController
{
    // 1. First Generation (The Grid of Options)
    public function getGenerate(): void
    {
        $this->checkAuth();

        $userId = (int) $_SESSION['user_id'];
        $responseModel = new ResponseModel();
        $answers = $responseModel->getAnswersByUserId($userId);

        if (!$answers) {
            header('Location: /EvolveAi/questionaire/view');
            exit;
        }

        $meaningfulAnswers = array_filter(
            $answers, 
            fn($k) => !in_array($k, ['csrf_token', 'submit', '_token']), 
            ARRAY_FILTER_USE_KEY
        );

        // Generate the Grid of Opportunities
        $html = ResponseService::generateOpportunities($meaningfulAnswers);

        // Save to DB
        $planModel = new DailyPlanModel();
        $planModel->saveTodayPlan($userId, $html);

        header('Location: /EvolveAi/dashboard/view');
        exit;
    }

    // 2. Second Generation (The Detailed Plan + Opportunities below)
    public function postPlan(): void
    {
        $this->checkAuth();
        $userId = (int) $_SESSION['user_id'];

        // A. Get the CURRENT HTML (The Opportunities Grid) before we overwrite it
        $planModel = new DailyPlanModel();
        $opportunitiesHtml = $planModel->getTodayPlan($userId);

        // B. Collect data from the form
        $selectedOpportunity = [
            'title' => $_POST['opportunity_title'] ?? 'Selected Opportunity',
            'description' => $_POST['opportunity_desc'] ?? '',
            'context' => $_POST['opportunity_context'] ?? ''
        ];

        // C. Generate the new Detailed Plan
        $planHtml = ResponseService::generateExecutionPlan($selectedOpportunity);

        // D. Merge: Put the Plan on top, and the Opportunities (Grid) at the bottom
        // We only do this if we actually found old opportunities
        if ($opportunitiesHtml) {
            $finalHtml = $this->mergeHtml($planHtml, $opportunitiesHtml);
        } else {
            $finalHtml = $planHtml;
        }

        // E. Save the Combined Result
        $planModel->saveTodayPlan($userId, $finalHtml);

        header('Location: /EvolveAi/dashboard/view');
        exit;
    }

    /**
     * Helper to combine two HTML documents into one.
     * It takes the BODY content of the $bottomHtml and appends it to the $topHtml.
     */
    private function mergeHtml(string $topHtml, string $bottomHtml): string
    {
        // 1. Extract the body content from the Bottom HTML (The Grid)
        // We use regex to grab everything between <body> and </body>
        preg_match('/<body[^>]*>(.*?)<\/body>/is', $bottomHtml, $matches);
        $bottomBodyContent = $matches[1] ?? '';

        if (!$bottomBodyContent) {
            return $topHtml; // Failed to extract, just return the plan
        }

        // 2. Create a divider section
        $divider = '
            <div class="w-full max-w-7xl mx-auto px-4 py-12">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="bg-white px-3 text-lg font-semibold text-gray-900">
                            Explore Other Opportunities
                        </span>
                    </div>
                </div>
            </div>
        ';

        // 3. Inject the Divider + Bottom Content just before the closing </body> of the Top HTML
        return str_replace(
            '</body>', 
            $divider . $bottomBodyContent . '</body>', 
            $topHtml
        );
    }

    private function checkAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            exit('Unauthorized');
        }
    }
}