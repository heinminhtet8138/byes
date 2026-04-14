<?php
/**
 * Course Management Logic
 * Handles CRUD operations for courses
 */

include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Sanitize and collect inputs
    $title = htmlspecialchars($_POST['title'] ?? '');
    $description = $_POST['description'] ?? '';
    $category_id = intval($_POST['category_id'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $duration = htmlspecialchars($_POST['duration'] ?? '');
    $id = $_POST['id'] ?? null;

    // Handle Image Upload
    $image_path = '';
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['course_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = 'course_' . uniqid() . '.' . $ext;
            $upload_dir = '../assets/images/courses/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $destination = $upload_dir . $new_filename;
            if (move_uploaded_file($_FILES['course_image']['tmp_name'], $destination)) {
                $image_path = 'assets/images/courses/' . $new_filename;
            }
        }
    }

    // Database Operations using Prepared Statements
    try {
        if ($action === 'create') {
            
            $sql = "INSERT INTO courses (category_id, title, description, price, duration, image_path) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$category_id, $title, $description, $price, $duration, $image_path]);
            
            header('Location: manage-courses.php?status=success&msg=Course+created+successfully');
        } elseif ($action === 'update' && $id) {
            
            $sql = "UPDATE courses SET category_id = ?, title = ?, description = ?, price = ?, duration = ?" . 
                   ($image_path ? ", image_path = ?" : "") . " WHERE id = ?";
            $params = [$category_id, $title, $description, $price, $duration];
            if ($image_path) $params[] = $image_path;
            $params[] = $id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            header('Location: manage-courses.php?status=success&msg=Course+updated+successfully');
        }
    } catch (Exception $e) {
        header('Location: /admin/manage-courses.php?status=error&msg=An+error+occurred');
    }
}

// Handle Delete

if (isset($_POST['action']) && $_POST['action'] == 'delete_course') {
    $id = $_POST['id'];

    // ၁။ ဒီ Course မှာ ကျောင်းသား (Enrollment) ရှိမရှိ အရင်စစ်မယ်
    $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE course_id = ?");
    $check_stmt->execute([$id]);
    $student_count = $check_stmt->fetchColumn();
    
    if ($student_count > 0) {
        // ကျောင်းသားရှိနေရင် ဖျက်ခွင့်မပေးဘဲ Error Message ပို့မယ်
        echo "has_students"; 
        exit;
    }

    // ၂။ ကျောင်းသားမရှိမှသာ Course ကို ဖျက်မယ်
    $delete = $pdo->prepare("DELETE FROM courses WHERE id = ?");
    $delete->execute([$id]);
    
    echo "success";
    exit;
}
?>
