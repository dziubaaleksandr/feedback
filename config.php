<?php
$envFilePath = __DIR__ . '/.env';
$envVariables = parse_ini_file($envFilePath);

define('DB_NAME', $envVariables['MYSQL_DATABASE']);
define('DB_USER', $envVariables['MYSQL_USER']);
define('DB_PASSWORD', $envVariables['MYSQL_PASSWORD']);
