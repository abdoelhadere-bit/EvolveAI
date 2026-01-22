<?php

namespace App\Controllers;

use App\Services\ProfileService;

class QuestionaireController {
    protected $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }

    // Router looks for: get + View = getView
    public function getView() {
        require_once '../App/Views/QuestionaireForm/questionaire.php';
    }

    // Router looks for: post + Store = postStore
    // Note: Change 'store' to 'postStore' to handle the form submission
   

    public function postStore() {
    try {
        $this->profileService->saveUserResponse($_POST);
        // Redirect to dashboard with a status that triggers AI generation
        header('Location: /EvolveAi/dashboard?status=generating');
        exit;
    } catch (\Exception $e) {
        // If it fails, go back to the questionnaire with the error
        header('Location: /EvolveAi/questionaire/view?error=' . urlencode($e->getMessage()));
        exit;
    }
}
}