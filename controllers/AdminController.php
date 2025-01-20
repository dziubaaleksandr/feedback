<?php
require_once 'models/FeedbackModel.php';
require_once 'models/UserModel.php';

class AdminController {
    private $feedbackModel;
    private $userModel;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        $pdo = new PDO('mysql:host=mysql-db;dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->feedbackModel = new FeedbackModel($pdo);
        $this->userModel = new UserModel($pdo);
    }

    public function showLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->authenticate($_POST['username'], $_POST['password']);
            if ($user) {
                session_start();
                $_SESSION['admin'] = true;
                header('Location: /admin.php');
                exit;
            }
        }
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

    public function showAdminPanel() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /login.php');
            exit;
        }

        if (isset($_GET['delete'])) {
            $this->feedbackModel->deleteFeedback($_GET['delete']);
        }

        $feedbacks = $this->feedbackModel->getFeedback();

        $this->renderAdminView($feedbacks);
    }

    private function renderAdminView($feedbacks) {
        $xsl = new DOMDocument();
        $xsl->load('views/admin_panel.xsl');

        $xml = new DOMDocument();
        $feedbacksXML = '<feedbacks>';
        foreach ($feedbacks as $feedback) {
            $feedbacksXML .= '<feedback>';
            foreach ($feedback as $key => $value) {
                $feedbacksXML .= "<$key>" . htmlspecialchars($value) . "</$key>";
            }
            $feedbacksXML .= '</feedback>';
        }
        $feedbacksXML .= '</feedbacks>';

        $xml->loadXML($feedbacksXML);
        $processor = new XSLTProcessor();
        $processor->importStylesheet($xsl);
        echo $processor->transformToXml($xml);
    }
}
