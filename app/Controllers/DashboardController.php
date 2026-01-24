<?php

namespace App\Controllers;

use App\Models\DailyPlanModel;

final class DashboardController
{
    public function getView(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /EvolveAI/public/index.php?url=auth/login');
            exit;
        }

        $model = new DailyPlanModel();
        
        $dailyPlanHtml = $model->getTodayPlan($userId);

        // If no plan exists, force redirect to questionnaire
        if (!$dailyPlanHtml) {
            header('Location: /EvolveAi/public/index.php?url=questionaire/view');
            exit;
        }

        // Pass it to the view
        require __DIR__ . '/../Views/dashboard/dashboard.php';
    }
}