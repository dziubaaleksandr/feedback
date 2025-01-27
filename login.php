<?php
require_once 'config.php';
require_once 'controllers/AdminController.php';
require_once 'validators/Validator.php';

$controller = new AdminController(DB_NAME, DB_USER, DB_PASSWORD);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->validate(new LoginValidator());
}
$controller->showLogin();
