<?php
session_start();
session_unset();
session_destroy();

// Logout ပြီးရင် Login Page ကို ပြန်သွားမယ်
header("Location: ../index.php");
exit();
?>