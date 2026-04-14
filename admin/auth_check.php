<?php
session_start();

// Session ထဲမှာ user_id မရှိရင် (Login မဝင်ထားရင်)
if (!isset($_SESSION['user_id'])) {
    // Login Page ကို ပြန်လွှတ်မယ်
    header("Location: login.php");
    exit();
}
?>