<?php

namespace App\Models;

use App\Core\Database;
use PDO;

final class ArticleModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM articles 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check if we already generated articles TODAY (to avoid spamming on every refresh)
    public function hasGeneratedToday(int $userId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM articles 
            WHERE user_id = :user_id 
            AND DATE(created_at) = CURRENT_DATE
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function create(int $userId, string $title, string $content, string $links): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO articles (user_id, title, content, links, created_at)
            VALUES (:user_id, :title, :content, :links, NOW())
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':content' => $content,
            ':links' => $links
        ]);
    }

    public function delete(int $articleId, int $userId): void
    {
        $stmt = $this->db->prepare("
            DELETE FROM articles 
            WHERE id = :id AND user_id = :user_id
        ");
        $stmt->execute([
            ':id' => $articleId,
            ':user_id' => $userId
        ]);
    }
}