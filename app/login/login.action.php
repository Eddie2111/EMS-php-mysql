<?php
session_start();
require_once "../env.config.php";
include "../common/db/queryBuilder.php";
include "../common/db/tables.php";
include "../common/utils/jwt.php";
include "./login.constants.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = ERROR_REQUIRED_FIELDS;
        header("Location: /login?message=" . urlencode(ERROR_REQUIRED_FIELDS));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = ERROR_INVALID_EMAIL;
        header("Location: /login?message=" . urlencode(ERROR_INVALID_EMAIL));
        exit;
    }

    try {
        $conditions = ['email' => $email];
        $user = $queryBuilder->select(USERS_TABLE, '*', $conditions);

        if (!empty($user) && password_verify($password, $user[0]['password'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['success'] = SUCCESS_LOGIN;

            $jwtPayload = [
                'sub' => $user[0]['id'],
                'email' => $user[0]['email'],
                'iat' => time(),
                'exp' => time() + 3600
            ];

            $jwtToken = encodeJWT($jwtPayload, JWT_SECRET);
            setcookie('token', $jwtToken, time() + 3600, '/', '', true, true);

            header("Location: /dashboard?message=" . urlencode(SUCCESS_LOGIN));
            exit;
        } else {
            $_SESSION['error'] = ERROR_INVALID_CREDENTIALS;
            header("Location: /login?message=" . urlencode(ERROR_INVALID_CREDENTIALS));
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = ERROR_LOGIN_FAILED . " " . $e->getMessage();
        header("Location: /login?message=" . urlencode(ERROR_LOGIN_FAILED));
        exit;
    }
} else {
    header("Location: /login/");
    exit;
}
