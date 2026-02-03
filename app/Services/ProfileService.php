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

        $jsonAnswers = json_encode($data, JSON_THROW_ON_ERROR);

        $sql = "
    UPDATE users
    SET answers = :answers
    WHERE id = :user_id
";


        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId,
            ':answers' => $jsonAnswers,
        ]);

        return true;
    }
}
