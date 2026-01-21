<?php 

require_once '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");

define('URLROOT', 'http://localhost/EvolveAi');

use App\Core\Router;

$router= new Router();
?>