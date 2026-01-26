<?php

namespace App\Services;

use App\Core\Database;
use Exception;
use PDO;

class ProfileService {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function saveUserResponse(array $data) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            throw new Exception("Unauthorized: No user session found.");
        }

        // 1. Prepare the JSON data
        // We remove 'url' or any other non-question fields if they exist
        unset($data['url']);
        $jsonAnswers = json_encode($data);

        // 2. Map specific columns if you want to keep your table's existing fields synced
        // These are the specific columns in your existing user_profiles table
        $aiFamiliarity = $data['ai_exp'] ?? 'Beginner';
        $incomeGoal = 0; // You can calculate this or map it from your steps
        $timePerDay = ($data['daily_time'] === 'Full') ? 480 : 60; // Example mapping to INT
        $learningPref = $data['learning'] ?? 'Video';
        $profStatus = $data['industry'] ?? 'General';

        // 3. PostgreSQL Upsert (ON CONFLICT)
        $sql = "INSERT INTO user_profiles (
                    user_id, ai_familiarity, income_goal, time_per_day, 
                    learning_preference, professional_status, answers, updated_at
                ) 
                VALUES (
                    :user_id, :ai, :income, :time, :learning, :status, :answers, NOW()
                ) 
                ON CONFLICT (user_id) 
                DO UPDATE SET 
                    ai_familiarity = EXCLUDED.ai_familiarity,
                    income_goal = EXCLUDED.income_goal,
                    time_per_day = EXCLUDED.time_per_day,
                    learning_preference = EXCLUDED.learning_preference,
                    professional_status = EXCLUDED.professional_status,
                    answers = EXCLUDED.answers,
                    updated_at = NOW()";

        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            ':user_id'  => $userId,
            ':ai'       => $aiFamiliarity,
            ':income'   => $incomeGoal,
            ':time'     => $timePerDay,
            ':learning' => $learningPref,
            ':status'   => $profStatus,
            ':answers'  => $jsonAnswers
        ]);

        return true;
    }
}