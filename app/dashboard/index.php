<?php
session_start();
include("../common/guards/auth.guard.php");

try {
    // Verify the JWT token
    $userId = verifyJWT();

    // If JWT is valid, display the dashboard content
    echo "JWT file included successfully!<br>";
    echo "Welcome to your dashboard, user ID: " . htmlspecialchars($userId);
} catch (Exception $e) {
    // Redirect to the login page if authentication fails
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}
