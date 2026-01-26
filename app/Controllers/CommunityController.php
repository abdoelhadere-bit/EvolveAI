<?php

namespace App\Controllers;

use App\Models\CommunityPost;
use App\Services\PostService;
use App\Core\Database;

class CommunityController {
    private PostService $postService;

    public function __construct() {
        // Uses your group's Singleton
        $this->postService = new PostService(Database::getConnection());
    }

    // URL: /Community/view (GET)
    public function getView() {
        $posts = $this->postService->getAllPosts();
        require_once '../App/Views/PostCommunity/community_view.php';
    }

    // URL: /Community/store (POST)
    public function postStore() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Safety check for user session
        $userId = $_SESSION['user_id'] ?? 1; // Fallback for testing

        $newPost = new CommunityPost(
            userId: (int)$userId,
            title: $_POST['title'] ?? '',
            content: $_POST['content'] ?? '',
            postType: $_POST['post_type'] ?? 'experience'
        );

        $newId = $this->postService->createPost($newPost);

        if ($newId) {
            // Redirects to /Community/show/ID
            header("Location: show/" . $newId);
            exit;
        } else {
            echo "Database Error: Could not save post.";
        }
    }

    // URL: /Community/show/{id} (GET)
    public function getShow($id = null) {
        if (!$id) {
            header("Location: ../view");
            exit;
        }

        $post = $this->postService->getPostById((int)$id);
        if (!$post) die("Post not found.");

        require_once '../App/Views/PostCommunity/post_detail.php';
    }
}