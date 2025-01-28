<?php
include("../../../common/db/QueryBuilder.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $eventId = intval($_POST['id']);

    try {
        // Delete the event
        $result = $queryBuilder->delete('Event', ['id' => $eventId]);

        if ($result) {
            // Redirect to events page after successful deletion
            header('Location: /dashboard?delete=success');
            exit;
        } else {
            header('Location: /dashboard/event?id=' . $eventId . '&error=delete_failed');
            exit;
        }
    } catch (Exception $e) {
        header('Location: /dashboard/event?id=' . $eventId . '&error=delete_failed');
        exit;
    }
} else {
    header('Location: /dashboard');
    exit;
}
