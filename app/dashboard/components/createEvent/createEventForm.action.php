<?php
session_start();
include("../../../common/guards/auth.guard.php");
include("../../../common/headers/index.php");
include("../../../common/db/queryBuilder.php");
include("../../../common/db/tables.php");

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim(htmlspecialchars($_POST['title']));
    $description = htmlspecialchars($_POST['description']);
    $startDate = htmlspecialchars($_POST['startDate']);
    $endDate = htmlspecialchars($_POST['endDate']);
    $location = htmlspecialchars($_POST['location']);
    $capacity = isset($_POST['capacity']) ? (int)$_POST['capacity'] : null;

    $errors = [];

    if (empty($title)) {
        $errors[] = "Title is required.";
    } elseif (strlen($title) > 100) {
        $errors[] = "Title must not exceed 100 characters.";
    }

    if (empty($startDate)) {
        $errors[] = "Start Date is required.";
    } elseif (!DateTime::createFromFormat('Y-m-d\TH:i', $startDate)) {
        $errors[] = "Invalid Start Date format.";
    }

    if (empty($endDate)) {
        $errors[] = "End Date is required.";
    } elseif (!DateTime::createFromFormat('Y-m-d\TH:i', $endDate)) {
        $errors[] = "Invalid End Date format.";
    } elseif ($startDate >= $endDate) {
        $errors[] = "End Date must be later than Start Date.";
    }

    if ($capacity === null || $capacity <= 0) {
        $errors[] = "Capacity must be a positive number.";
    } elseif ($capacity > 100000) {
        $errors[] = "Capacity cannot exceed 100,000.";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode(" ", $errors);
        header("Location: /createEventForm.php");
        exit;
    }

    $eventData = [
        'title' => $title,
        'description' => $description,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'location' => $location,
        'capacity' => $capacity,
        'creatorId' => $userId,
    ];

    try {
        $queryBuilder->insert(EVENTS_TABLE, $eventData);
        header("Location: /dashboard?message=Event+created+successfully.");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to create event: " . $e->getMessage();
        header("Location: /createEventForm.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /createEventForm.php");
    exit;
}
