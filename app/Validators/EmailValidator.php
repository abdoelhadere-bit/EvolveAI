<?php

namespace App\Validators;

use Exception;

class EmailValidator
{
    public function validateEmail($email): string
    {
        if (empty($email)) {
            throw new Exception("Email is required.");
        }

        
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        return $email;
    }
}

?>

