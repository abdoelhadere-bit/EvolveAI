<?php

namespace App\Controllers;

use App\Validators\LoginValidator;
use App\Validators\SignupValidator;
use App\Repositories\UserRepository;
use App\Models\UserModel;
use Exception;

class AuthController
{
    private UserRepository $users;
    private SignupValidator $signupValidator;
    private LoginValidator $loginValidator;

    public function __construct()
    {
        $this->users = new UserRepository();
        $this->signupValidator = new SignupValidator();
        $this->loginValidator = new LoginValidator();
    }

    public function getLogin()
    {
        require_once '../app/Views/auth/login.php';
    }

    public function getSignup()
    {
        require_once '../app/Views/auth/signup.php';
    }

public function postSignup(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    try {
        $user = new UserModel(
            null,
            $_POST['full_name'] ?? null,
            $_POST['email'] ?? null,
            $_POST['password'] ?? null,
            null,
            $_POST['confirm_password'] ?? null
        );

        $validated = $this->signupValidator->validate($user);

        if ($this->users->findByEmail($validated->getEmail())) {
            throw new Exception("Email already exists.");
        }

        // Create user and retrieve ID
        $userId = $this->users->create($validated);

        // 🔑 START SESSION AND SAVE USER ID
        session_start();
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['login_time'] = time();

        header("Location: " . URLROOT . "/questionaire/view");
        exit;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


    public function postLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        
            $user= new userModel (
                null,
                null,
                $_POST['email'],
                $_POST['password'],
                null,
                null
            );

            var_dump($_POST['password']);
            var_dump($user);

        }

        try {
            
            $credentials = $this->loginValidator->validate($user);

            
            $user = $this->users->findByEmail($credentials->getEmail());

             
            if (!$user || !password_verify($credentials->getPassword(), $user->getPassword())) {
                throw new Exception("Invalid email or password.");
            }

            session_start();
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->getId();
            
            $_SESSION['login_time']= time();

            header("Location: " . URLROOT . "/home/view");
            exit;

        } catch (Exception $e) {
            echo $e->getMessage();
        
    }
    }
    public function getlogout(): void
    {
        session_unset();
        session_destroy();
        header("Location: " . URLROOT . "/landing");
        exit;
    }
}

