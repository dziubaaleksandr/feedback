<?php
require_once 'config.php';
require_once 'controllers/AdminController.php';

$controller = new AdminController(DB_NAME, DB_USER, DB_PASSWORD);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->validateLogin();
}
$controller->showLogin();
