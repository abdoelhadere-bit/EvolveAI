<?php

namespace App\Services;

use PDO;
use DateTime;
use App\Core\Database;
use App\Models\OTP;

class OtpService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function generateOtp(int $length = 6): string
    {
        $digits = '0123456789';
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= $digits[random_int(0, 9)];
        }

        return $otp;
    }

    public function saveOtp(int $userId, string $otp): void
    {
        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);
        $expiresAt = (new DateTime('+10 minutes'))->format('Y-m-d H:i:s');

        $stmt = $this->db->prepare("
            INSERT INTO user_otps (user_id, otp_hash, expires_at)
            VALUES (:user_id, :otp, :expires_at)
            ON CONFLICT (user_id)
            DO UPDATE SET otp_hash = :otp, expires_at = :expires_at
        ");

        $stmt->execute([
            'user_id' => $userId,
            'otp' => $hashedOtp,
            'expires_at' => $expiresAt
        ]);
    }

    public function verifyOtp( string $inputOtp): bool
    {
        
        $otp= unserialize($_SESSION['OTP']);

        if (!$otp) {
            return false;
        }

        if (new DateTime() > $otp->getExpiresAt()) {
            return false; 
        }

        return password_verify($inputOtp, $otp->getOtpHash());
    }

    private function map(array $row): OTP
    {
        return new OTP(
            (int) $row['user_id'],
            $row['otp_hash'],
            new DateTime($row['expires_at'])
        );
    }

    public function getOTP(int $userId): ?OTP
    {
        $stmt = $this->db->prepare("
            SELECT user_id, otp_hash, expires_at
            FROM user_otps
            WHERE user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; 
        }

        return $this->map($row);
    }
}
