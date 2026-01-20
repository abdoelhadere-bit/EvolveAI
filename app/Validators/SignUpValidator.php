<?php

namespace app\Validators;

use Exception;
use app\Model\User;

class SignupValidator
{
    public function validate(User $user): User
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

        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception("Password must contain at least one uppercase letter.");
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception("Password must contain at least one lowercase letter.");
        }

        if (!preg_match('/[\W_]/', $password)) {
            throw new Exception("Password must contain at least one special character.");
        }

        if($password !== $user->getConfirmPassword()) { throw new Exception("paassword do not match.");}

        $user->setFname(trim($user->getFname()));
        $user->setEmail(trim($user->getEmail()));
        $user->setPassword(password_hash($user->getPassword(),PASSWORD_DEFAULT));
        $user->setConfirmPassword(null);

        return $user;
    }
}