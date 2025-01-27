<?php
require_once 'config.php';
require_once 'controllers/FeedbackController.php';
require_once 'validators/Validator.php';

$controller = new FeedbackController(DB_NAME, DB_USER, DB_PASSWORD);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->validate(new FileValidator());
}
$controller->showFeedbackForm();
