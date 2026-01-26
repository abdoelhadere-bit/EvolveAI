<?php

namespace App\Services;

use App\Models\CommunityPost;
use PDO;

class PostService {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createPost(CommunityPost $post): int|bool {
        $sql = "INSERT INTO community_posts (user_id, title, content, post_type) 
                VALUES (:u, :t, :c, :p) RETURNING id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':u' => $post->getUserId(),
            ':t' => $post->getTitle(),
            ':c' => $post->getContent(),
            ':p' => $post->getPostType()
        ]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? (int)$res['id'] : false;
    }

    public function getPostById(int $id): ?CommunityPost {
        $stmt = $this->db->prepare("SELECT * FROM community_posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? CommunityPost::fromArray($row) : null;
    }

    public function getAllPosts(): array {
        $stmt = $this->db->query("SELECT * FROM community_posts ORDER BY id DESC");
        $posts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = CommunityPost::fromArray($row);
        }
        return $posts;
    }
}