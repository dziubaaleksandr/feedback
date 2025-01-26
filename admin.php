<?php
require_once 'config.php';
require_once 'controllers/AdminController.php';

$controller = new AdminController(DB_NAME, DB_USER, DB_PASSWORD);
$controller->showAdminPanel();
