<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");

define('URLROOT', 'http://localhost/EvolveAI');

use App\Core\Router;

$router= new Router();
?>