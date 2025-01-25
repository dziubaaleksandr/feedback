<?php
require_once 'controllers/AdminController.php';
$envFilePath = __DIR__ . '/.env';
$envVariables = parse_ini_file($envFilePath);
$DB_NAME = $envVariables['MYSQL_DATABASE']; 
$DB_USER = $envVariables['MYSQL_USER'];
$DB_PASSWORD = $envVariables['MYSQL_PASSWORD'];
$controller = new AdminController($DB_NAME, $DB_USER, $DB_PASSWORD);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temp = $controller->validateLogin();
}
$controller->showLogin();
