<?php
/**
 * Blog Management Logic
 * Handles CRUD operations for blog posts
 */

include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] === 'create' || $_POST['action'] === 'update')) {
    $action = $_POST['action'] ?? '';
    
    // Sanitize and collect inputs
    $title = htmlspecialchars($_POST['title'] ?? '');
    $content = $_POST['content'] ?? ''; // Blog content (Longtext)
    $category = htmlspecialchars($_POST['category'] ?? '');
    $author_name = htmlspecialchars($_POST['author_name'] ?? 'Admin');
    $status = $_POST['status'] ?? 'Draft';
    $id = $_POST['id'] ?? null;

    // Handle Image Upload
    $image_path = '';
    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['blog_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = 'blog_' . uniqid() . '.' . $ext;
            // Blog အတွက် folder path ကို ပြင်ထားပါတယ်
            $upload_dir = '../uploads/blog/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $destination = $upload_dir . $new_filename;
            if (move_uploaded_file($_FILES['blog_image']['tmp_name'], $destination)) {
                $image_path = 'uploads/blog/' . $new_filename;
            }
        }
    }

    // Database Operations
    try {
        if ($action === 'create') {
            
            $sql = "INSERT INTO blog_posts (title, content, category, image_path, author_name, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $content, $category, $image_path, $author_name, $status]);
            
            header('Location: manage-blogs.php?status=success&msg=Post+published+successfully');
            
        } elseif ($action === 'update' && $id) {
            
            $sql = "UPDATE blog_posts SET title = ?, content = ?, category = ?, author_name = ?, status = ?" . 
                   ($image_path ? ", image_path = ?" : "") . " WHERE id = ?";
            
            $params = [$title, $content, $category, $author_name, $status];
            if ($image_path) $params[] = $image_path;
            $params[] = $id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            header('Location: manage-blogs.php?status=success&msg=Post+updated+successfully');
        }
    } catch (Exception $e) {
        header('Location: manage-blogs.php?status=error&msg=An+error+occurred');
    }
    exit;
}

// Handle Delete (AJAX)
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    try {
        // ၁။ ပုံလမ်းကြောင်းကို အရင်ယူမယ် (Server ပေါ်ကပါ ဖျက်ချင်ရင်)
        $stmt = $pdo->prepare("SELECT image_path FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();

        // ၂။ Database ကနေ ဖျက်မယ်
        $delete = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        $delete->execute([$id]);

        // ၃။ ပုံရှိရင် Folder ထဲကပါ တစ်ခါတည်း ရှင်းထုတ်မယ်
        if ($post && !empty($post['image_path'])) {
            $full_path = '../' . $post['image_path'];
            if (file_exists($full_path)) {
                unlink($full_path);
            }
        }
        
        echo "success";
    } catch (Exception $e) {
        echo "error";
    }
    exit;
}