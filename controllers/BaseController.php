<?php

abstract class BaseController {
    protected $pdo;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        $this->pdo = new PDO('mysql:host=mysql-db;dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD);
    }

    protected function sendJsonResponse($statusCode, $message) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode(['message' => $message]);
        exit;
    }

    protected function renderView($xslFilePath, $xmlData) {
        $xsl = new DOMDocument();
        $xsl->load($xslFilePath);

        $xml = new DOMDocument();
        $xml->loadXML($xmlData);

        $processor = new XSLTProcessor();
        $processor->importStylesheet($xsl);
        echo $processor->transformToXml($xml);
    }
}
