<?php
ob_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="event_attendees.pdf"');

$eventId = isset($_GET['eventId']) ? intval($_GET['eventId']) : null;

if (!$eventId) {
    http_response_code(400);
    echo json_encode(['error' => 'Event ID is required']);
    exit;
}

$eventWithAttendees = $queryBuilder->selectWithJoin(
    'Event',
    'Event.*, User.name as creator_name',
    [
        [
            'type' => 'left',
            'table' => 'User',
            'on' => 'Event.creatorId = User.id'
        ]
    ],
    ['Event.id' => $eventId]
);

if (empty($eventWithAttendees)) {
    http_response_code(404);
    echo json_encode(['error' => 'Event not found']);
    exit;
}

$event = $eventWithAttendees[0];

$attendees = $queryBuilder->selectWithJoin(
    'Attendee',
    'User.name, User.email, User.phone',
    [
        [
            'type' => 'left',
            'table' => 'User',
            'on' => 'Attendee.userId = User.id'
        ]
    ],
    ['Attendee.eventId' => $eventId]
);

$pdf = "Event Attendees List\n\n";
$pdf .= "Event: " . $event['title'] . "\n";
$pdf .= "Description: " . ($event['description'] ?? 'N/A') . "\n";
$pdf .= "Date: " . date('Y-m-d H:i', strtotime($event['startDate'])) . " to " . date('Y-m-d H:i', strtotime($event['endDate'])) . "\n";
$pdf .= "Location: " . ($event['location'] ?? 'N/A') . "\n";
$pdf .= "Created by: " . $event['creator_name'] . "\n\n";

$pdf .= "Attendees:\n";
$pdf .= str_pad("Name", 30) . str_pad("Email", 35) . "Phone\n";
$pdf .= str_repeat("-", 80) . "\n";

foreach ($attendees as $attendee) {
    $pdf .= str_pad($attendee['name'] ?? 'N/A', 30) .
        str_pad($attendee['email'] ?? 'N/A', 35) .
        ($attendee['phone'] ?? 'N/A') . "\n";
}


$tempFile = tempnam(sys_get_temp_dir(), 'pdf');
file_put_contents($tempFile, $pdf);


readfile($tempFile);
unlink($tempFile);
exit;
