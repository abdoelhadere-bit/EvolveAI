<?php

namespace App\Controllers;

final class LandingController
{
    public function getIndex(): void
    {
        // Simply render the landing view
        require __DIR__ . '/../Views/landing/index.php';
    }
}
