<?php
require_once 'config.php';
require_once 'controllers/FeedbackController.php';

$controller = new FeedbackController(DB_NAME, DB_USER, DB_PASSWORD);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->validateFile();
}
$controller->handleRequest();
