<?php

require_once 'controllers/FeedbackController.php';
$envFilePath = __DIR__ . '/.env';
$envVariables = parse_ini_file($envFilePath);

$DB_NAME = $envVariables['MYSQL_DATABASE']; 
$DB_USER = $envVariables['MYSQL_USER'];
$DB_PASSWORD = $envVariables['MYSQL_PASSWORD'];

$controller = new FeedbackController($DB_NAME, $DB_USER, $DB_PASSWORD);
$controller->handleRequest();
