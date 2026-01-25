<?php

namespace App\Controllers;

use App\Services\ProfileService;

final class QuestionaireController
{
    private ProfileService $profileService;

    public function __construct()
    {
        $this->profileService = new ProfileService();
    }

    public function getView(): void
    {
        require_once __DIR__ . '/../Views/QuestionaireForm/questionaire.php';
    }

    public function postStore(): void
    {
        try {
            $this->profileService->saveUserResponse($_POST);

            header('Location: /EvolveAI/public/index.php?url=response/generate');
            exit;

        } catch (\Throwable $e) {
            header(
                'Location: /EvolveAI/public/index.php?url=questionaire/view?error=' .
                urlencode($e->getMessage())
            );
            exit;
        }
    }
}
