<?php
require_once 'controllers/BaseController.php';
require_once 'models/FeedbackModel.php';

class FeedbackController extends BaseController{
    private $model;

    public function __construct($DB_NAME, $DB_USER, $DB_PASSWORD) {
        parent::__construct($DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->model = new FeedbackModel($this->pdo);
    }

    public function validate($validator) {
        $res = $validator->validate($this->model);
        $this->sendJsonResponse($res[0], $res[1]);
    }

    public function showFeedbackForm() {
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
        $this->renderView('views/feedback_form.xsl', '<feedback/>');
    }
}
