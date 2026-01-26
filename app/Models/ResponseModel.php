<?php

namespace App\Models;

use App\Core\Database;
use PDO;

final class ResponseModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAnswersByUserId(int $userId): ?array
    {
        $sql = "
            SELECT answers
            FROM users
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $userId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || $row['answers'] === null) {
            return null;
        }

        return json_decode($row['answers'], true, 512, JSON_THROW_ON_ERROR);
    }
}
