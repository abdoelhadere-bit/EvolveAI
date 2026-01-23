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
            header('Location: /EvolveAi/login');
            exit;
        }

        $model = new DailyPlanModel();
        
        // WE NAME THE VARIABLE $dailyPlanHtml HERE:
        $dailyPlanHtml = $model->getTodayPlan($userId);

        // If no plan exists, force redirect to questionnaire
        if (!$dailyPlanHtml) {
            header('Location: /EvolveAi/questionaire/view');
            exit;
        }

        // Pass it to the view
        require __DIR__ . '/../Views/dashboard/dashboard.php';
    }
}