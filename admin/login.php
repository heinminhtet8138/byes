<?php 
session_start();
// Login ဝင်ထားပြီးသား ဖြစ်နေရင် Dashboard ကို တန်းလွှတ်မယ်
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// ------------------------------
include '../includes/db_connect.php'; 

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
 // 1. User ရိုက်လိုက်တဲ့ password ကို Plain Text အတိုင်း ယူပါ (Hash မလုပ်ပါနဲ့)
    $password = $_POST['password']; 

    // 2. Database ထဲက user ကို ဆွဲထုတ်ပါ
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 3. password_verify function ကို သုံးပြီး စစ်ပါ
    // $password က "password123" ဖြစ်ပြီး $user['password'] က DB ထဲက hash စာသားကြီး ဖြစ်ပါတယ်
    if ($user && password_verify($password, $user['password'])) {
        
        // Login အောင်မြင်ပြီ! Session သတ်မှတ်ပြီး Dashboard ကို လွှတ်ပါ
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
        
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Boot Your English Skills</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-primary {
            border-radius: 8px;
            padding: 12px;
        }
        .input-group-text {
            border-color: #dee2e6;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h1 class="fw-bold text-primary"><i class="bi bi-mortarboard-fill"></i></h1>
            <h2 class="fw-bold">Admin Portal</h2>
            <p class="text-muted">Please sign in to manage your school</p>
        </div>
        
        <div class="card login-card">
            <div class="card-body p-5">
                <?php if($error): ?>
                    <div class="alert alert-danger py-2 small border-0 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold small text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="username" name="username" placeholder="admin" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold small text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                        Sign In <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-12 text-center mt-4">
            <a href="../index.php" class="text-decoration-none text-muted small">
                <i class="bi bi-house-door me-1"></i> Back to Main Website
            </a>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>