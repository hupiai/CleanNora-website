<?php
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';
$name = getenv('DB_NAME') ?: '';
$conn = mysqli_connect($host, $user, $pass, $name);
if (!$conn) { die('Database connection failed.'); }
?>
