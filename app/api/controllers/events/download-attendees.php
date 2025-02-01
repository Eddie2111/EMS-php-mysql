<?php
ob_start();
header('Access-Control-Allow-Origin: *');

function logError($message, $context = []) {
    error_log("ERROR: $message" . (!empty($context) ? " | Context: " . print_r($context, true) : ""));
}

try {
    // Step 1: Validate Event ID
    if (!isset($_GET['eventId']) || !filter_var($_GET['eventId'], FILTER_VALIDATE_INT)) {
        throw new InvalidArgumentException('Valid Event ID is required');
    }
    $eventId = (int)$_GET['eventId'];

    // Step 2: Fetch Event Details
    $event = $queryBuilder->select('Event', '*', ['id' => $eventId]);
    if (empty($event)) {
        throw new RuntimeException('Event not found', 404);
    }
    $event = $event[0];

    // Step 3: Fetch Attendees with User Details
    $attendees = $queryBuilder->selectWithJoin(
        'Attendee',
        'Attendee.id, Attendee.eventId, Attendee.userId, Attendee.registeredAt, User.name, User.email',
        [
            [
                'type' => 'LEFT',
                'table' => 'User',
                'on' => 'Attendee.userId = User.id'
            ]
        ],
        ['eventId' => $eventId]
    );

    // Log attendees for debugging
    logError('Fetched attendees:', ['attendees' => $attendees]);

    if (empty($attendees)) {
        throw new RuntimeException('No attendees found for this event', 404);
    }

    // Step 4: Prepare CSV Data
    $csvData = [];
    $headers = ['Name', 'Email', 'Registration Date'];
    $csvData[] = $headers;

    foreach ($attendees as $attendee) {
        if (!is_array($attendee)) {
            logError('Invalid attendee data format', ['attendee' => $attendee]);
            continue;
        }
        $name = isset($attendee['name']) && !empty($attendee['name']) ? $attendee['name'] : 'N/A';
        $email = isset($attendee['email']) && filter_var($attendee['email'], FILTER_VALIDATE_EMAIL) ? $attendee['email'] : 'N/A';
        $registrationDate = isset($attendee['registeredAt']) && !empty($attendee['registeredAt']) ? $attendee['registeredAt'] : 'N/A';

        $csvData[] = [$name, $email, $registrationDate];
    }

    // Step 5: Generate CSV File
    $filename = 'event_attendees_' . $eventId . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    if (!$output) {
        throw new RuntimeException('Failed to create CSV output stream');
    }

    foreach ($csvData as $row) {
        if (!fputcsv($output, $row)) {
            throw new RuntimeException('Failed to write row to CSV');
        }
    }

    fclose($output);
    exit;
} catch (InvalidArgumentException $e) {
    // Invalid input error
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    logError($e->getMessage(), ['input' => $_GET]);
} catch (RuntimeException $e) {
    // Runtime error (e.g., no attendees, file generation failure)
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    logError($e->getMessage(), ['eventId' => $eventId]);
} catch (PDOException $e) {
    // Database connection or query error
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred'
    ]);
    logError('Database error: ' . $e->getMessage(), ['query' => $e->getTraceAsString()]);
} catch (Exception $e) {
    // General exception
    echo json_encode([
        'success' => false,
        'error' => 'An internal server error occurred'
    ]);
    logError('Unexpected error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
}