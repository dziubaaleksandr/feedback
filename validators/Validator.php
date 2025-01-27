<?php

interface BaseValidator {
    public function validate($model);
}

class FileValidator implements BaseValidator {
    public function validate($model) {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file'];
            if ($file['size'] > 1048576) {
                return [401, 'Файл слишком большой. Максимум 1 МБ.'];
            }

            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $uploadedFile = '/uploads/' . $fileName;
                $model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'], $uploadedFile);
                return [200, 'Отзыв оставлен успешно.'];
            }
            return [401, 'Ошибка при попытке оставить отзыв.'];
        }
        $model->saveFeedback($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
        return [200, 'Отзыв оставлен успешно.'];
    }
}

class LoginValidator implements BaseValidator{
    public function validate($model) {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $user = $model->authenticate($username, $password);

        if ($user) {
            session_start();
            $_SESSION['admin'] = true;
            return [200, 'Успешный вход'];
        }
        return [401, 'Неверный логин или пароль'];
    }
}

