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

    public function getFeedback() {
        $stmt = $this->pdo->prepare('SELECT * FROM feedback');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFeedback($id) {
        $stmt = $this->pdo->prepare('DELETE FROM feedback WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function countFeedback() {
        return $this->pdo->query('SELECT COUNT(*) FROM feedback')->fetchColumn();
    }
}
