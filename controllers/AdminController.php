<?php
require_once 'controllers/BaseController.php';
require_once 'models/FeedbackModel.php';
require_once 'models/UserModel.php';

class AdminController extends BaseController{
    private $feedbackModel;
    private $userModel;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        parent::__construct($DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->feedbackModel = new FeedbackModel($this->pdo);
        $this->userModel = new UserModel($this->pdo);
    }

    public function validate($validator) {
        $res = $validator->validate($this->userModel);
        $this->sendJsonResponse($res[0], $res[1]);
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

        $this->renderView('views/admin_panel.xsl', $this->generateAdminXml($feedbacks, $pages));
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
        $this->renderView('views/login_form.xsl', '<login/>');
    }

    private function calculatePagination()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
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

    private function generateAdminXml($feedbacks, $pages) {
        $feedbacksXML = '<feedbacks>';
        foreach ($feedbacks as $feedback) {
            $feedbacksXML .= '<feedback>';
            foreach ($feedback as $key => $value) {
                if (!isset($value)) { continue; }
                if ($key === 'file_path') {
                    $feedbacksXML .= "<$key><![CDATA[<a href='$value' target='_blank'>Скачать файл</a>]]></$key>";
                    continue;
                }
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
        return $feedbacksXML;
    }
}
