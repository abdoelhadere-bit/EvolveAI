<?php

namespace App\Validators;

use Exception;
use App\Models\UserModel;

class LoginValidator
{
    public function validate(UserModel $user): UserModel
    {
        
        if (empty($user->getEmail()) || empty($user->getEmail())) {
            throw new Exception("Email and password are required.");
        }

        
        $email = trim($user->getEmail());
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        
        if (strlen($user->getPassword()) < 1) {
            throw new Exception("Password cannot be empty.");
        }

        $user->setEmail($email);
        $user->setPassword(trim($user->getPassword()));
        return $user;
    }
}