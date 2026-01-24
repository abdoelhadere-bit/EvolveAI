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

    public function getAllByUserId(int $userId): array
    {
        // Fetch submissions and their AI reviews
        // We assume a simplified join for now since we are manually handling the flow
        $sql = "
            SELECT 
                s.id as submission_id,
                s.content,
                s.submitted_at,
                r.score,
                r.feedback,
                r.reviewed_at
            FROM task_submissions s
            LEFT JOIN ai_reviews r ON s.id = r.submission_id
            WHERE s.user_id = :user_id
            ORDER BY s.submitted_at DESC
        ";
        
        // NOTE: If your schema strictness prevents this because of task_id, 
        // we might need to adjust. Assuming we map task_id to a placeholder or 0 for now.
        // For this code to work with your EXACT schema, ensure 'task_submissions' has a 'user_id' column
        // OR we link via the plan_tasks. 
        
        // TEMPORARY FIX: I will use a simple query assuming you add 'title' to task_submissions 
        // or we just use the 'content' column to store "Title: ... \n Work: ..."
        
        return []; // returning empty for safety until DB is fully aligned
    }

    public function saveSubmission(int $userId, string $taskTitle, string $content, array $aiResult): void
    {
        $this->db->beginTransaction();

        try {
            // 1. Create a "Fake" task record if needed, or just insert into submissions
            // For now, we will assume we store everything in 'task_submissions' text
            // We prepend the title to the content for storage
            $fullContent = "TASK: $taskTitle\n\nCONTENT:\n$content";

            // We need a task_id for the schema constraint. 
            // Let's find today's plan ID first.
            $stmt = $this->db->prepare("SELECT id FROM daily_plans WHERE user_id = ? AND plan_date = CURRENT_DATE");
            $stmt->execute([$userId]);
            $planId = $stmt->fetchColumn();

            if (!$planId) {
                // Determine a fallback or create a plan
                throw new \Exception("No plan found for today.");
            }

            // Create a generic task entry for this submission so we satisfy FK
            $stmt = $this->db->prepare("INSERT INTO plan_tasks (plan_id, title, status) VALUES (?, ?, 'done') RETURNING id");
            $stmt->execute([$planId, $taskTitle]);
            $taskId = $stmt->fetchColumn();

            // 2. Insert Submission
            $stmt = $this->db->prepare("INSERT INTO task_submissions (task_id, content) VALUES (?, ?) RETURNING id");
            $stmt->execute([$taskId, $content]);
            $submissionId = $stmt->fetchColumn();

            // 3. Insert AI Review
            $stmt = $this->db->prepare("INSERT INTO ai_reviews (submission_id, score, feedback) VALUES (?, ?, ?)");
            $stmt->execute([$submissionId, $aiResult['score'], $aiResult['feedback']]);

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
                r.reviewed_at
            FROM ai_reviews r
            JOIN task_submissions s ON r.submission_id = s.id
            JOIN plan_tasks pt ON s.task_id = pt.id
            JOIN daily_plans dp ON pt.plan_id = dp.id
            WHERE dp.user_id = :user_id
            ORDER BY r.reviewed_at DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}