<?php

namespace App\Controllers;

use App\Services\ProfileService;

class QuestionaireController {
    protected $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }

    
    public function getView() {
        require_once '../App/Views/QuestionaireForm/questionaire.php';
    }
   

    public function postStore() {
    try {
        $this->profileService->saveUserResponse($_POST);
        
        header('Location: /EvolveAi/dashboard?status=generating');
        exit;
    } catch (\Exception $e) {
       
        header('Location: /EvolveAi/questionaire/view?error=' . urlencode($e->getMessage()));
        exit;
    }
}
}