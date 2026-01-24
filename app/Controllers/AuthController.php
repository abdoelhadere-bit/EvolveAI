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
            $_SESSION["toast_error"] = "does not have access to change the password";
            header("Location: " . URLROOT . "/auth/login");

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
            
            $validated = $this->signupValidator->validate($user);

            if ($this->users->findByEmail($validated->getEmail())) {
                throw new Exception("Email already exists.");
            }

            $_SESSION['user_id']= $this->users->create($validated);
            
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
                
                        $_SESSION["toast_error"] = $e->getMessage();
                        header("Location: " . URLROOT . "/auth/forgot");
                        exit;
                    }

                }
            }
        }
        catch(Exception $e)
        {
            $_SESSION["toast_error"] = $e->getMessage();
            header("Location: " . URLROOT . "/auth/forgot");
            exit;
        }

        try{
            $user = $this->users->findByEmail($email);

            if(!$user) { throw new Exception("this account doesn't exists"); }
            
            else {   $this->verificationSteps($user); }
        }
        catch(Exception $e ){
            $_SESSION["toast_error"] = $e->getMessage();
            header("Location: " . URLROOT . "/auth/forgot");
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

                    header("Location: " . URLROOT . "/auth/newpassword");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['toast_error'] = "could not verify OTP, a new one will be sent".$e->getMessage();
                    $this->verificationSteps($user);
                    exit;
                }
            }
            else header("Location: " . URLROOT . "/auth/forgot");
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

        header("Location: " . URLROOT . "/auth/verifyOTP");
    }

    public function postNewPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (!isset($_SESSION['allow_new_password'])) {
            header("Location: " . URLROOT . "/auth/login");
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
            $_SESSION['toast_error']= "failed to reset password". $e->getMessage();
            header("Location: ". URLROOT. "/auth/newpassword");
            exit;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if($this->users->updatePassword($user->getId(), $hashedPassword))
        {
            unset($_SESSION['allow_new_password']);
            unset($_SESSION['user']);
            unset($_SESSION['OTP']);

            $_SESSION['toast_success']= "password updated successfully";
            header("Location:".URLROOT."/auth/login");
            exit;
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

