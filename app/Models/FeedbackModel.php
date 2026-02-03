<?php

namespace App\Models;

use App\Core\Database;
use PDO;

final class FeedbackModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function saveSubmission(int $userId, string $taskTitle, string $content, array $aiResult): void
    {
        $this->db->beginTransaction();

        try {
            $planId = $this->getOrCreateTodayPlan($userId);
            $taskId = $this->createTaskForSubmission($planId, $taskTitle);
            $submissionId = $this->insertSubmission($taskId, $userId, $content);
            $this->insertAiReview($submissionId, $aiResult);

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getHistory(int $userId): array
    {
        $sql = "
            SELECT 
                pt.title as task_title,
                r.score,
                r.feedback,
                s.content,
                r.created_at as reviewed_at
            FROM ai_reviews r
            JOIN task_submissions s ON r.submission_id = s.id
            JOIN plan_tasks pt ON s.task_id = pt.id
            JOIN daily_plans dp ON pt.daily_plan_id = dp.id
            WHERE dp.user_id = :user_id
            ORDER BY r.created_at DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getOrCreateTodayPlan(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT id FROM daily_plans 
            WHERE user_id = :user_id AND plan_date = CURRENT_DATE
        ");
        $stmt->execute([':user_id' => $userId]);
        $planId = $stmt->fetchColumn();

        if ($planId) {
            return (int) $planId;
        }

        $stmt = $this->db->prepare("
            INSERT INTO daily_plans (user_id, plan_date, day_number) 
            VALUES (:user_id, CURRENT_DATE, 1) 
            RETURNING id
        ");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    private function createTaskForSubmission(int $planId, string $taskTitle): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO plan_tasks (daily_plan_id, title, status, type, estimated_minutes) 
            VALUES (:plan_id, :title, 'done', 'action', 30) 
            RETURNING id
        ");
        $stmt->execute([
            ':plan_id' => $planId,
            ':title' => $taskTitle
        ]);
        return (int) $stmt->fetchColumn();
    }

    private function insertSubmission(int $taskId, int $userId, string $content): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO task_submissions (task_id, user_id, content) 
            VALUES (:task_id, :user_id, :content) 
            RETURNING id
        ");
        $stmt->execute([
            ':task_id' => $taskId,
            ':user_id' => $userId,
            ':content' => $content
        ]);
        return (int) $stmt->fetchColumn();
    }

    private function insertAiReview(int $submissionId, array $aiResult): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO ai_reviews (submission_id, score, feedback) 
            VALUES (:submission_id, :score, :feedback)
        ");
        $stmt->execute([
            ':submission_id' => $submissionId,
            ':score' => $aiResult['score'] ?? 0,
            ':feedback' => $aiResult['feedback'] ?? ''
        ]);
    }
}