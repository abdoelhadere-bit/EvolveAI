<?php

namespace App\Validators;
use Exception;

class PasswordValidator
{
    public function validatePassword(string $password, string $confirm_password): void
    {
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

        if($password !== $confirm_password) { throw new Exception("paassword do not match.");}

        return;
    }
}

?>