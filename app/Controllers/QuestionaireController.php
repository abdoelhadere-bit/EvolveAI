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

    // GET /questionaire/view
    public function getView(): void
    {
        require_once __DIR__ . '/../Views/QuestionaireForm/questionaire.php';
    }

    // POST /questionaire/store
    public function postStore(): void
    {
        try {
            // Save questionnaire answers
            $this->profileService->saveUserResponse($_POST);

            // Redirect to AI generation controller
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
