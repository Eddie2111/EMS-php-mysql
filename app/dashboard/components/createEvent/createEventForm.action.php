<?php
session_start();

include("../../../common/guards/auth.guard.php");
include("../../../common/headers/index.php");
include("../../../common/db/QueryBuilder.php");
include("../../../common/db/tables.php");

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $startDate = htmlspecialchars($_POST['startDate']);
    $endDate = htmlspecialchars($_POST['endDate']);
    $location = htmlspecialchars($_POST['location']);
    $capacity = isset($_POST['capacity']) ? (int)$_POST['capacity'] : null;

    if (empty($title) || empty($startDate) || empty($endDate)) {
        $_SESSION['error'] = "Title, Start Date, and End Date are required.";
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
