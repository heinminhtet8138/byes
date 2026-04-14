<?php
// error_reporting ကို ခဏဖွင့်ထားမယ် (Debug လုပ်ဖို့)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form data တွေကို သေချာဖမ်းမယ်
    $student_name  = $_POST['name'] ?? '';
    $student_email = $_POST['email'] ?? '';
    $phone         = $_POST['phone'] ?? '';
    $course_id     = $_POST['course_id'] ?? '';
    $payment_slip  = $_FILES['payment_slip'] ?? null;

    if (!$payment_slip || $payment_slip['error'] !== 0) {
        echo "error_upload_file";
        exit;
    }

    $upload_dir = 'uploads/payments/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($payment_slip['name'], PATHINFO_EXTENSION));
    $new_file_name  = "slip_" . time() . "_" . uniqid() . "." . $file_extension;
    $target_file    = $upload_dir . $new_file_name;

    if (move_uploaded_file($payment_slip['tmp_name'], $target_file)) {
        try {
            // Table column နာမည်တွေ (student_name, student_email, phone, course_id, payment_slip) မှန်မမှန် ပြန်စစ်ပါ
            $sql = "INSERT INTO enrollments (student_name, student_email, phone, course_id, payment_slip, status) 
                    VALUES (?, ?, ?, ?, ?, 'Pending')";
            
            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute([
                $student_name, 
                $student_email, 
                $phone, 
                $course_id, 
                $new_file_name
            ]);

            if ($success) {
                echo "success"; // ဒီစာသားပဲ ထွက်ရမယ်
            } else {
                echo "db_execute_failed";
            }
        } catch (PDOException $e) {
            echo "db_error: " . $e->getMessage();
        }
    } else {
        echo "file_move_failed";
    }
    exit;
}