<?php 

header("Access-Control-Allow-Origin: *");

define('URLROOT', 'http://localhost/EvolveAi');

require_once '../vendor/autoload.php';

session_start();

use app\Core\Router;

$Router = new Router();

?>