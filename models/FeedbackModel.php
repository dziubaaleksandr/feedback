<?php
class FeedbackModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveFeedback($name, $email, $subject, $message) {
        $stmt = $this->pdo->prepare('INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $subject, $message]);
    }

}
