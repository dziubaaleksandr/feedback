<?php
require_once 'models/FeedbackModel.php';

class FeedbackController {
    private $model;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        $pdo = new PDO('mysql:host=mysql-db;dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->model = new FeedbackModel($pdo);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
            header('Location: /');
            exit;
        }
        $this->renderView();
    }

    private function renderView() {
        $xsl = new DOMDocument();
        $xsl->load('views/feedback_form.xsl');

        $xml = new DOMDocument();
        $xml->loadXML('<feedback/>');

        $processor = new XSLTProcessor();
        $processor->importStylesheet($xsl);
        echo $processor->transformToXml($xml);
    }
}
