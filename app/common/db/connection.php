<?php
$host = 'db';
$db = 'event_management';
$user = 'mysql';
$password = 'mysql';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
