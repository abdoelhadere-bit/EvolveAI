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
        
        $plan = $model->getTodayPlan($userId);

        require __DIR__ . '/../Views/dashboard/dashboard.php';
    }

    public function postUpdateTask(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Simple auth check
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $taskId = $input['taskId'] ?? null;
            $status = $input['status'] ?? null; 

            if ($taskId && $status) {
                $model = new DailyPlanModel();
                $success = $model->updateTaskStatus((int)$taskId, $status, (int)$_SESSION['user_id']);
                
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        
        http_response_code(400);
        echo json_encode(['error' => 'Invalid Request']);
        exit;
    }
}