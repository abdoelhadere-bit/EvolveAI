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

    public function saveTodayPlan(int $userId, string $html): void
    {
        // 1. First, delete any existing plan for today 
        // (This prevents the "Duplicate" error and works on ALL databases)
        $deleteSql = "
            DELETE FROM daily_plans 
            WHERE user_id = :user_id 
              AND plan_date = CURRENT_DATE
        ";
        
        $stmt = $this->db->prepare($deleteSql);
        $stmt->execute([':user_id' => $userId]);

        // 2. Now, insert the new plan
        $insertSql = "
            INSERT INTO daily_plans (user_id, plan_date, html_content)
            VALUES (:user_id, CURRENT_DATE, :plan_content)
        ";

        $stmt = $this->db->prepare($insertSql);
        $stmt->execute([
            ':user_id' => $userId,
            ':plan_content' => $html,
        ]);
    }

    public function getTodayPlan(int $userId): ?string
    {
        $stmt = $this->db->prepare("
            SELECT html_content
            FROM daily_plans
            WHERE user_id = :user_id
              AND plan_date = CURRENT_DATE
        ");

        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchColumn() ?: null;
    }
}