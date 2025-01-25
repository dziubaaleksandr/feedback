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
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $user = $this->userModel->authenticate($_POST['username'], $_POST['password']);
        //     if ($user) {
        //         session_start();
        //         $_SESSION['admin'] = true;
        //         header('Location: /admin.php');
        //         exit;
        //     }
        // }
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

    private function calculatePagination()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 2;
        $offset = ($page - 1) * $limit;
        $feedbacks = $this->feedbackModel->getFeedback($offset, $limit);
        $totalFeedback = $this->feedbackModel->countFeedback();
        $totalPages = ceil($totalFeedback / $limit);
        $pages = [];
        for($i = 1; $i <= $totalPages; $i++){
            $pages[] = $i;
        }
        return ['feedbacks'=>$feedbacks, 'pages'=>$pages];
    }

    public function showAdminPanel() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /login.php');
            exit;
        }

        if (isset($_GET['delete'])) {
            $this->feedbackModel->deleteFeedback($_GET['delete']);
            header('Location: /admin.php');
        }

        $feedbacks = $this->calculatePagination()['feedbacks'];
        $pages = $this->calculatePagination()['pages'];

        $this->renderAdminView($feedbacks, $pages);
    }

    private function renderAdminView($feedbacks, $pages) {
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
        $feedbacksXML .= '<pagination>';
        foreach ($pages as $page) {
            $feedbacksXML .= "<page>$page</page>";
        }
        $feedbacksXML .= '</pagination>';
        $feedbacksXML .= '</feedbacks>';

        $xml->loadXML($feedbacksXML);
        $processor = new XSLTProcessor();
        $processor->importStylesheet($xsl);
        echo $processor->transformToXml($xml);
    }

    public function validateLogin()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->userModel->authenticate($username, $password);
        if ($user) {
            session_start();
            $_SESSION['admin'] = true;
            http_response_code(200);
            echo json_encode(['message' => 'Успешный вход']);
            exit;
        }
        http_response_code(401);
        echo json_encode(['message' => 'Неверный логин или пароль']);
        exit;
    }
}
