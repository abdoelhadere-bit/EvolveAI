<?php

namespace App\Models;

use App\Core\Database;
use PDO;

final class DailyPlanModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Count how many plans the user has generated before
    public function getPlanCount(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM daily_plans WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    public function saveTodayPlan(int $userId, array $tasks, int $dayNumber, ?int $opportunityId = null): void
    {
        try {
            $this->db->beginTransaction();

            // Delete existing plan for today to avoid conflicts
            $deleteSql = "DELETE FROM daily_plans WHERE user_id = :user_id AND plan_date = CURRENT_DATE";
            $stmt = $this->db->prepare($deleteSql);
            $stmt->execute([':user_id' => $userId]);

            // Insert new plan 
            $insertSql = "
                INSERT INTO daily_plans (user_id, plan_date, day_number, opportunity_id)
                VALUES (:user_id, CURRENT_DATE, :day_number, :opportunity_id)
                RETURNING id
            ";
            $stmt = $this->db->prepare($insertSql);
            $stmt->execute([
                ':user_id' => $userId,
                ':day_number' => $dayNumber,
                ':opportunity_id' => $opportunityId
            ]);
            $planId = (int) $stmt->fetchColumn();

            // Insert tasks
            $taskSql = "
                INSERT INTO plan_tasks (daily_plan_id, title, details, estimated_minutes, status, type)
                VALUES (:plan_id, :title, :details, :est_min, 'todo', 'action')
            ";
            $taskStmt = $this->db->prepare($taskSql);

            foreach ($tasks as $task) {
                $estMin = 30;
                if (isset($task['deadline'])) {
                    preg_match('/(\d+)/', $task['deadline'], $matches);
                    if (!empty($matches[1])) {
                        $estMin = (int) $matches[1];
                    }
                }
                if (isset($task['estimated_minutes'])) {
                    $estMin = (int) $task['estimated_minutes'];
                }

                $taskStmt->execute([
                    ':plan_id' => $planId,
                    ':title' => $task['title'] ?? 'Untitled Task',
                    ':details' => $task['description'] ?? '',
                    ':est_min' => $estMin
                ]);
            }

            $this->db->commit();

        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getTodayPlan(int $userId): ?array
    {
        // Fetch Plan
        $stmt = $this->db->prepare("
            SELECT id, plan_date, status, progress_percent, day_number
            FROM daily_plans
            WHERE user_id = :user_id
              AND plan_date = CURRENT_DATE
        ");
        $stmt->execute([':user_id' => $userId]);
        $plan = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$plan) {
            return null;
        }

        // Fetch Tasks
        $taskStmt = $this->db->prepare("
            SELECT id, title, details as description, status, estimated_minutes as deadline
            FROM plan_tasks
            WHERE daily_plan_id = :plan_id
            ORDER BY id ASC
        ");
        $taskStmt->execute([':plan_id' => $plan['id']]);
        $plan['tasks'] = $taskStmt->fetchAll(PDO::FETCH_ASSOC);

        return $plan;
    }

    public function updateTaskStatus(int $taskId, string $status, int $userId): bool
    {
        $checkSql = "
            SELECT COUNT(*) 
            FROM plan_tasks pt
            JOIN daily_plans dp ON pt.daily_plan_id = dp.id
            WHERE pt.id = :task_id AND dp.user_id = :user_id
        ";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':task_id' => $taskId, ':user_id' => $userId]);
        
        if ($checkStmt->fetchColumn() == 0) {
            return false; 
        }

        $stmt = $this->db->prepare("UPDATE plan_tasks SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $taskId]);
    }
}
