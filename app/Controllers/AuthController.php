<?php

namespace App\Controllers;

use App\Validators\LoginValidator;
use App\Validators\SignupValidator;
use App\Repositories\UserRepository;
use App\Models\UserModel;
use App\Validators\EmailValidator;
use App\Services\OtpService;
use App\Services\EmailService;
use App\Validators\PasswordValidator;
use Exception;

class AuthController
{
    private UserRepository $users;
    private SignupValidator $signupValidator;
    private LoginValidator $loginValidator;
    private EmailValidator $emailValidator;

    public function __construct()
    {
        $this->users = new UserRepository();
        $this->signupValidator = new SignupValidator();
        $this->loginValidator = new LoginValidator();
        $this->emailValidator = new EmailValidator();
    }

    public function getLogin()
    {
        require_once '../app/Views/auth/login.php';
    }

    public function getSignup()
    {
        require_once '../app/Views/auth/signup.php';
    }


    public function getForgot()
    {
        require_once '../app/Views/auth/passwordreset.php';
    }

    public function getVerifyOTP()
    {
        require_once '../app/Views/auth/verifyOTP.php';
    }

    public function getNewpassword()
    {
        if(isset($_SESSION['allow_new_password'] )&& $_SESSION['allow_new_password']===true) require_once '../app/Views/auth/newpassword.php';
        else {
            $_SESSION['error'] = "does not have access to change the password";
            header("Location: " . URLROOT . "/public/index.php?url=auth/login");

        }
    }

    public function postSignup(): void
    {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user= new userModel (
                    null,
                    $_POST['full_name']? $_POST['full_name'] : null,
                    $_POST['email']? $_POST['email'] : null,
                    $_POST['password'] ? $_POST['password'] : null,
                    null,
                    $_POST['confirm_password'] ? $_POST['confirm_password'] : null
                );
            }

        try {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            $validated = $this->signupValidator->validate($user);

            if ($this->users->findByEmail($validated->getEmail())) {
                $_SESSION['error'] = "Email already exists. Please log in or use a different email.";
                header("Location: /EvolveAI/public/index.php?url=auth/signup");
                exit;
            }

            // Create user and retrieve ID
            $userId = $this->users->create($validated);
            
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $userId;
            $_SESSION['login_time'] = time();
            
            header("Location: /EvolveAI/public/index.php?url=questionaire/view");
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /EvolveAI/public/index.php?url=auth/signup");
            exit;
        }

    }


    public function postLogin(): void
    {
        try {
            if (session_status() === PHP_SESSION_NONE) session_start();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Invalid request method.");
            }

            $user = new UserModel(
                null,
                null,
                $_POST['email'] ?? null,
                $_POST['password'] ?? null,
                null,
                null
            );
            
            $credentials = $this->loginValidator->validate($user);
            $userFound = $this->users->findByEmail($credentials->getEmail());
             
            if (!$userFound || !password_verify($credentials->getPassword(), $userFound->getPassword())) {
                throw new Exception("Invalid email or password.");
            }

            session_regenerate_id(true);

            $_SESSION['user_id'] = $userFound->getId();
            $_SESSION['login_time'] = time();

            header("Location: " . URLROOT . "/public/index.php?url=dashboard/view");
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . URLROOT . "/public/index.php?url=auth/login");
            exit;
        }
    }

    public function postForgot()
    {
        try 
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if(isset($_POST['email']))
                {
                    try
                    {
                        $email = $this->emailValidator->validateEmail($_POST['email']);
                    }
                    catch (Exception $e) {
                
                        $_SESSION['error'] = $e->getMessage();
                        header("Location: " . URLROOT . "/public/index.php?url=auth/forgot");
                        exit;
                    }

                }
            }
        }
        catch(Exception $e)
        {
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . URLROOT . "/public/index.php?url=auth/forgot");
            exit;
        }

        try{
            $user = $this->users->findByEmail($email);

            if(!$user) { throw new Exception("this account doesn't exists"); }
            
            else {   $this->verificationSteps($user); }
        }
        catch(Exception $e ){
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . URLROOT . "/public/index.php?url=auth/forgot");
            exit;
        }

    }

    public function postVerifyOTP()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = unserialize($_SESSION['user']);
            $inputOtp = $_POST['otp'] ?? '';

            if($user){
                try {
                    $otpService = new OtpService();
                    $otpService->verifyOtp($inputOtp);

                    $_SESSION['allow_new_password']=true;

                    header("Location: " . URLROOT . "/public/index.php?url=auth/newpassword");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['error'] = "could not verify OTP, a new one will be sent".$e->getMessage();
                    $this->verificationSteps($user);
                    exit;
                }
            }
            else header("Location: " . URLROOT . "/public/index.php?url=auth/forgot");
        }

    }


    public function verificationSteps(UserModel $user)
    {
        $otpservice = new OtpService();

        $otp= $otpservice->generateOtp();
        $otpservice->saveOtp($user->getId(), $otp);

        $mailer = new EmailService();

        $mailer->sendOtp($user->getEmail(), $otp);

        $_SESSION['OTP']= serialize($otpservice->getOTP($user->getId()));
        $_SESSION['user'] = serialize($user);

        header("Location: " . URLROOT . "/public/index.php?url=auth/verifyOTP");
    }

    public function postNewPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (!isset($_SESSION['allow_new_password'])) {
            header("Location: " . URLROOT . "/public/index.php?url=auth/login");
            exit;
        }

        $user = unserialize($_SESSION['user']);
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $passwordValidator= new PasswordValidator();


        try
        {
            $passwordValidator->validatePassword($newPassword, $confirmPassword);

        } catch (Exception $e )
        {
            $_SESSION['error']= "failed to reset password". $e->getMessage();
            header("Location: ". URLROOT. "/public/index.php?url=auth/newpassword");
            exit;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if($this->users->updatePassword($user->getId(), $hashedPassword))
        {
            unset($_SESSION['allow_new_password']);
            unset($_SESSION['user']);
            unset($_SESSION['OTP']);

            $_SESSION['success']= "password updated successfully";
            header("Location:".URLROOT."/public/index.php?url=auth/login");
            exit;
        }
    }

    public function getlogout(): void
    {
        session_unset();
        session_destroy();
        header("Location: " . URLROOT . "/public/index.php?url=landing");
        exit;
    }
}

