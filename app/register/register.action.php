<?php
session_start();

include "../common/db/queryBuilder.php";
include "../common/db/tables.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if (empty($email) || empty($password) || empty($name)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: /register/");
        exit;
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: /register/");
        exit;
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $existingUser = $queryBuilder->select(USERS_TABLE, '*', ['email' => $email]);

            if (!empty($existingUser)) {
                $_SESSION['error'] = "Email is already registered.";
                header("Location: /register/");
                exit;
            } else {
                $queryBuilder->insert(USERS_TABLE, [
                    'email' => $email,
                    'password' => $hashedPassword,
                    'name' => $name,
                    'phone' => $phone
                ]);
                $_SESSION['success'] = "Registration successful! Please log in.";
                header("Location: /login/");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: /register/");
            exit;
        }
    }
} else {
    header("Location: /register/");
    exit;
}
