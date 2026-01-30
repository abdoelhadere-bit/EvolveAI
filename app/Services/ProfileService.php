<?php

namespace App\Services;

use App\Core\Database;
use Exception;
use PDO;

final class ProfileService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function saveUserResponse(array $data): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;

        if (!$userId) {
            throw new Exception('Unauthorized: No user session found.');
        }

        // Remove non-question fields
        unset($data['url']);

        // Merge "Other" fields
        // 1. Skills
        if (isset($data['skills']) && is_array($data['skills']) && in_array('other', $data['skills'])) {
             // Remove 'other' checkbox value
             $data['skills'] = array_diff($data['skills'], ['other']);
             // Add the custom text if provided
             if (!empty($data['skills_other'])) {
                 $data['skills'][] = $data['skills_other'];
             }
        }
        unset($data['skills_other']); // clean up

        // 2. Monetization
        if (isset($data['monetization']) && $data['monetization'] === 'other') {
            if (!empty($data['monetization_other'])) {
                $data['monetization'] = $data['monetization_other'];
            }
        }
        unset($data['monetization_other']); // clean up


        $jsonAnswers = json_encode($data, JSON_THROW_ON_ERROR);

        $sql = "UPDATE users SET answers = :answers WHERE id = :user_id";


        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId,
            ':answers' => $jsonAnswers,
        ]);

        return true;
    }
}
