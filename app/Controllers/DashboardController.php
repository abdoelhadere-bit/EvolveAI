<?php
namespace App\Controllers;

use App\Core\Controller;

class DashboardController
{
     public function getView() {
        require_once '../App/Views/dashboard/dashboard.php';
    }
}
