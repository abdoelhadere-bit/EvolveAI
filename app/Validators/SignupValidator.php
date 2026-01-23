<?php

namespace App\Validators;

use Exception;
use App\Models\UserModel;

class SignupValidator
{
    public function validate(UserModel $user): UserModel
    {

        if(empty($user->getFname())){ throw new Exception("The first name field is required."); }
        if(empty($user->getEmail())){ throw new Exception("The email field is required."); }
        if(empty($user->getPassword())){ throw new Exception("The Password field is required."); }
        if(empty($user->getConfirmPassword())){ throw new Exception("The confirm password field is required."); }

        $email = trim($user->getEmail());
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        $password = $user->getPassword();

        try 
        {
            $passwordValidator= new PasswordValidator();
            
            $passwordValidator->validatePassword($password, $user->getConfirmPassword());
        }catch(Exception $e)
        {
            $_SESSION['toast_error']= "failed to signup".$e->getMessage();
            header("Location: ". URLROOT. "/auth/signup");
        }

        $user->setFname(trim($user->getFname()));
        $user->setEmail(trim($user->getEmail()));
        $user->setPassword(password_hash($user->getPassword(),PASSWORD_DEFAULT));
        $user->setConfirmPassword(null);

        return $user;
    }
}