<?php

namespace App\Controllers;

final class CommunityController
{
    public function getIndex(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /EvolveAI/public/index.php?url=auth/login');
            exit;
        }

        require __DIR__ . '/../Views/dashboard/community.php';
    }
}
