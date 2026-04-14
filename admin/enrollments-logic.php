<?php
include '../includes/db_connect.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE enrollments SET status = ? WHERE id = ?");
        $result = $stmt->execute([$status, $id]);

        if ($result) {
            echo "success";
        } else {
            echo "failed_to_update";
        }
    } catch (PDOException $e) {
        echo "db_error: " . $e->getMessage();
    }
    exit;
}