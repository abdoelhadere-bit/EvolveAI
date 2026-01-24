<?php

namespace App\Models;

use DateTime;

class OTP
{
    private int $userId;
    private string $otpHash;
    private DateTime $expiresAt;

    public function __construct(int $userId, string $otpHash, DateTime $expiresAt)
    {
        $this->userId = $userId;
        $this->otpHash = $otpHash;
        $this->expiresAt = $expiresAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOtpHash(): string
    {
        return $this->otpHash;
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setOtpHash(string $otpHash): void
    {
        $this->otpHash = $otpHash;
    }

    public function setExpiresAt(DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }
}
