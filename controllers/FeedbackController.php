<?php
require_once 'models/FeedbackModel.php';

class FeedbackController {
    private $model;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        $pdo = new PDO('mysql:host=mysql-db;dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->model = new FeedbackModel($pdo);
    }

    public function handleRequest() {
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $uploadedFile = null;
        //     if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        //         $file = $_FILES['file'];
        //         if ($file['size'] > 1048576) {
        //             die('Файл слишком большой. Максимум 1 МБ.');
        //         }

        //         $uploadDir = __DIR__ . '/../uploads/';
        //         if (!is_dir($uploadDir)) {
        //             mkdir($uploadDir, 0777, true);
        //         }

        //         $fileName = uniqid() . '_' . basename($file['name']);
        //         $filePath = $uploadDir . $fileName;

        //         if (move_uploaded_file($file['tmp_name'], $filePath)) {
        //             $uploadedFile = '/uploads/' . $fileName;
        //         } else {
        //             die('Ошибка загрузки файла.');
        //         }
        //     }
        //     $this->model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'], $uploadedFile);
        //     header('Location: /');
        //     exit;
        // }
        $this->renderView();
    }

    public function validateFile()
    {
        header('Content-Type: application/json');
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file'];
            if ($file['size'] > 1048576) {
                http_response_code(401);
                echo json_encode(['message' => 'Файл слишком большой. Максимум 1 МБ.']);
                exit();
            }

            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $uploadedFile = '/uploads/' . $fileName;
                $this->model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'], $uploadedFile);
                http_response_code(200);
                echo json_encode(['message' => 'Отзыв оставлен успешно.']);
                exit();
            }
            http_response_code(401);
            echo json_encode(['message' => 'Ошибка при попытке оставить отзыв..']);
            exit();
        }
        $this->model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
        http_response_code(200);
        echo json_encode(['message' => 'Отзыв оставлен успешно.']);
        exit();
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
