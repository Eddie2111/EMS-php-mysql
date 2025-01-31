<?php
session_start();
include "../common/db/queryBuilder.php";
include "../common/db/tables.php";
include "./register.contants.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if (empty($email) || empty($password) || empty($name)) {
        $_SESSION['error'] = ERROR_REQUIRED_FIELDS;
        header("Location: /register?message=" . urlencode(ERROR_REQUIRED_FIELDS));
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = ERROR_INVALID_EMAIL;
        header("Location: /register?message=" . urlencode(ERROR_INVALID_EMAIL));
        exit;
    } else {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

        try {
            $existingUser = $queryBuilder->select(USERS_TABLE, '*', ['email' => $email]);
            if (!empty($existingUser)) {
                $_SESSION['error'] = ERROR_EMAIL_EXISTS;
                header("Location: /register?message=" . urlencode(ERROR_EMAIL_EXISTS));
                exit;
            } else {
                $queryBuilder->insert(USERS_TABLE, [
                    'email' => $email,
                    'password' => $hashedPassword,
                    'name' => $name,
                    'phone' => $phone
                ]);

                $_SESSION['success'] = SUCCESS_REGISTRATION;
                header("Location: /login?message=" . urlencode(SUCCESS_ACCOUNT_CREATED));
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = ERROR_ACCOUNT_CREATION;
            header("Location: /register?message=" . urlencode(ERROR_ACCOUNT_CREATION));
            exit;
        }
    }
} else {
    header("Location: /register/");
    exit;
}
