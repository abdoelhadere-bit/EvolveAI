<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        
        $this->mailer->isSMTP();
        $this->mailer->Host       = $_ENV['SMTP_HOST'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $_ENV['SMTP_USER'];
        $this->mailer->Password   = $_ENV['SMTP_PASS'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = 587;

        $this->mailer->setFrom('no-reply@yourapp.com', 'EvolveAI');
        $this->mailer->isHTML(true);
    }

    public function sendOtp(string $to, string $otp): void
    {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->Subject = "Your verification code";
            $this->mailer->Body    = "
                <h2>Verification Code</h2>
                <p>Your OTP is:</p>
                <h1 style='letter-spacing:3px;'>$otp</h1>
                <p>This code expires in 10 minutes.</p>
            ";

            $this->mailer->send();
        } catch (Exception $e) {
            throw new \Exception("Email could not be sent.");
        }
    }
}
