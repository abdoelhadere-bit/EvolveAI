<?php

namespace App\Controllers;

final class LandingController
{
    public function getIndex(): void
    {
        require __DIR__ . '/../Views/landing/index.php';
    }
}
