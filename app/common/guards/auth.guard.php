<?php

require_once __DIR__ . '/../../env.config.php';
require_once __DIR__ . '/../utils/jwt.php';

function verifyJWT()
{
    if (!isset($_COOKIE['token'])) {
        $_SESSION['error'] = 'Token not found. Please log in again.';
        header('Location: /login');
        exit();
    }

    $jwt = $_COOKIE['token'];

    try {
        $decoded = decodeJWT($jwt, JWT_SECRET);

        return $decoded['sub'];
    } catch (Exception $e) {
        $_SESSION['error'] = 'Invalid or expired token. Please log in again.';
        header('Location: /login');
        exit();
    }
}
