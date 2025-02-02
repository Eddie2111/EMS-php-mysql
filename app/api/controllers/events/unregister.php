<?php
ob_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

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

    $event = $queryBuilder->select('Event', '*', ['id' => $data['eventId']]);
    if (empty($event)) {
        throw new Exception('Event not found');
    }

    $existingRegistration = $queryBuilder->select('Attendee', '*', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (empty($existingRegistration)) {
        throw new Exception('You are not registered for this event');
    }

    $success = $queryBuilder->delete('Attendee', [
        'eventId' => $data['eventId'],
        'userId' => $userId
    ]);
    if (!$success) {
        throw new Exception('Failed to unregister from event');
    }

    $queryBuilder->commit();

    responseGenerator(['message' => 'Successfully removed registration from event'], 200);
} catch (Exception $e) {
    $queryBuilder->rollBack();
    responseGenerator(['error' => $e->getMessage()], 400);
}
