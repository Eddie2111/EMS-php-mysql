<?php
require __DIR__ . '/../../../common/guards/auth.guard.php';
require __DIR__ . '/../../helpers/response.helpers.php';

// Get the JSON input from the request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate that the event ID is provided
if (!isset($data['eventId'])) {
    responseGenerator(['error' => 'Event ID is required'], 400);
    exit;
}

try {
    // Verify the user's JWT token to ensure they are authenticated
    $userId = verifyJWT();
} catch (Exception $e) {
    responseGenerator(['error' => 'Unauthorized'], 401);
    exit;
}

try {
    // Begin a database transaction
    $queryBuilder->beginTransaction();

    // Fetch event details to ensure the event exists
    $event = $queryBuilder->select('Event', '*', ['id' => $data['eventId']]);
    if (empty($event)) {
        throw new Exception('Event not found');
    }

    // Check if the user is registered for the event
    $existingRegistration = $queryBuilder->select('Attendee', '*', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (empty($existingRegistration)) {
        throw new Exception('You are not registered for this event');
    }

    // Unregister the attendee by deleting their record
    $success = $queryBuilder->delete('Attendee', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (!$success) {
        throw new Exception('Failed to unregister from event');
    }

    // Commit the transaction
    $queryBuilder->commit();

    // Return success response
    responseGenerator(['message' => 'Successfully removed registration from event'], 200);
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $queryBuilder->rollBack();
    responseGenerator(['error' => $e->getMessage()], 400);
}
