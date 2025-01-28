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
    $eventId = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $startDate = htmlspecialchars($_POST['startDate']);
    $endDate = htmlspecialchars($_POST['endDate']);
    $location = htmlspecialchars($_POST['location']);
    $capacity = isset($_POST['capacity']) ? (int)$_POST['capacity'] : null;

    if (!$eventId || empty($title) || empty($startDate) || empty($endDate)) {
        $_SESSION['error'] = "Event ID, Title, Start Date, and End Date are required.";
        header("Location: /editEventForm.php?id=$eventId");
        exit;
    }

    try {
        $event = $queryBuilder->select(EVENTS_TABLE, '*', ['id' => $eventId]);

        if (empty($event)) {
            $_SESSION['error'] = "Event not found.";
            header("Location: /dashboard");
            exit;
        }

        $event = $event[0];

        if ($event['creatorId'] !== $userId) {
            $_SESSION['error'] = "You are not authorized to update this event.";
            header("Location: /dashboard");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to verify event ownership: " . $e->getMessage();
        header("Location: /dashboard");
        exit;
    }

    $updateData = [
        'title' => $title,
        'description' => $description,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'location' => $location,
        'capacity' => $capacity,
        'updatedAt' => date('Y-m-d H:i:s'),
    ];

    try {
        $queryBuilder->update(EVENTS_TABLE, $updateData, ['id' => $eventId]);
        header("Location: /dashboard?message=Event+updated+successfully.");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to update event: " . $e->getMessage();
        header("Location: /editEventForm.php?id=$eventId");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /dashboard");
    exit;
}