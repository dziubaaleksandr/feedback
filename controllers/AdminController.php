<?php
require_once 'models/FeedbackModel.php';

class AdminController {
    private $feedbackModel;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        $pdo = new PDO('mysql:host=mysql-db;dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->feedbackModel = new FeedbackModel($pdo);
    }

    public function showLogin() {
        $this->renderLoginView();
    }

    private function renderLoginView() {
        $xsl = new DOMDocument();
        $xsl->load('views/login_form.xsl');

        $xml = new DOMDocument();
        $xml->loadXML('<login/>');

        $processor = new XSLTProcessor();
        $processor->importStylesheet($xsl);
        echo $processor->transformToXml($xml);
    }

    
}
