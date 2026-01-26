<?php

namespace App\Validators;

use Exception;
use App\Models\UserModel;
use App\Validators\EmailValidator;

class LoginValidator
{
    public function validate(UserModel $user): UserModel
    {

        $emailValidator = new EmailValidator();

        $email = $emailValidator->validateEmail($user->getEmail());

        if (empty($user->getPassword())) {
            throw new Exception("Password is required.");
        }

        $user->setEmail($email);
        $user->setPassword(trim($user->getPassword()));
        return $user;
    }
}