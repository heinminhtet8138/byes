<?php
// Database connection configuration
$host = 'localhost';
$db   = 'boot_english_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // In a real environment, you would handle this error
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     
     // For the purpose of this UI/UX demo, we will just define a mock PDO if needed
     // but we'll assume the connection works in a real PHP environment.
}
?>
