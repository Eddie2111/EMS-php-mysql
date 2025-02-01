<?php
require __DIR__ . '/../../../common/guards/auth.guard.php';
require __DIR__ . '/../../helpers/response.helpers.php';
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['eventId'])) {
    responseGenerator(['error' => 'Event ID is required'], 400);
    exit;
}

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    responseGenerator(['error' => 'Unauthorized'], 401);
    exit;
}

try {
    $queryBuilder->beginTransaction();

    // Fetch event details
    $event = $queryBuilder->select('Event', '*', ['id' => $data['eventId']]);
    if (empty($event)) {
        throw new Exception('Event not found');
    }
    $event = $event[0];

    // Check if user is already registered
    $existingRegistration = $queryBuilder->select('Attendee', '*', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (!empty($existingRegistration)) {
        throw new Exception('You are already registered for this event');
    }

    // Check event capacity
    if ($event['capacity']) {
        $currentAttendees = $queryBuilder->select(
            'Attendee',
            'COUNT(*) as count',
            ['eventId' => $data['eventId']]
        );
        if ($currentAttendees[0]['count'] >= $event['capacity']) {
            throw new Exception('Event has reached maximum capacity');
        }
    }

    // Register the attendee
    $success = $queryBuilder->insert('Attendee', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (!$success) {
        throw new Exception('Failed to register for event');
    }

    // Commit the transaction
    $queryBuilder->commit();
    responseGenerator(['message' => 'Successfully registered for event'], 200);
} catch (Exception $e) {
    $queryBuilder->rollBack();
    responseGenerator(['error' => $e->getMessage()], 400);
}
