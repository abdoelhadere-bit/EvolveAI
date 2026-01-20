<?php

namespace app\Controllers;

use app\Validators\LoginValidator;
use app\Validators\SignupValidator;
use app\Repositories\UserRepository;
use app\Model\User;
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user= new user (
                    null,
                    $_POST['full_name']? $_POST['full_name'] : null,
                    $_POST['email']? $_POST['email'] : null,
                    $_POST['password'] ? $_POST['password'] : null,
                    null,
                    $_POST['confirm_password'] ? $_POST['confirm_password'] : null
                );
            }

        try {
            
            $validated = $this->signupValidator->validate($user);

            if ($this->users->findByEmail($validated->getEmail())) {
                throw new Exception("Email already exists.");
            }

            $this->users->create($validated);
            
            header("Location: " . URLROOT . "/home/view");
            exit;

        } catch (Exception $e) {
            
            echo $e->getMessage();
        }
    }

    public function postLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user= new user (
                null,
                null,
                null,
                $_POST['email'],
                $_POST['password'],
                null
            );

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

            header("Location: " . URLROOT . "/income/view");
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

