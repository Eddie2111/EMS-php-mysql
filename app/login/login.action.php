<?php
session_start();

require_once "../env.config.php";
include "../common/db/queryBuilder.php";
include "../common/db/tables.php";
include "../common/utils/jwt.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: /login/");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: /login/");
        exit;
    }

    try {
        $conditions = ['email' => $email];
        $user = $queryBuilder->select(USERS_TABLE, '*', $conditions);

        if (!empty($user) && password_verify($password, $user[0]['password'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['success'] = "Login successful! Welcome back.";

            $jwtPayload = [
                'sub' => $user[0]['id'],
                'email' => $user[0]['email'],
                'iat' => time(),
                'exp' => time() + 3600
            ];

            $jwtToken = encodeJWT($jwtPayload, JWT_SECRET);
            setcookie('token', $jwtToken, time() + 3600, '/', '', true, true);

            header("Location: /dashboard?message=Login+successful!+Welcome+back.");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: /login?message=Invalid+email+or+password");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: /login/");
        exit;
    }
} else {
    header("Location: /login/");
    exit;
}
