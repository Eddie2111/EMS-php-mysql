<?php
$searchTerm = $_GET['q'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$joins = [
    [
        'type' => 'left',
        'table' => 'event_attendees',
        'on' => 'events.id = event_attendees.event_id'
    ]
];

$conditions = [];
if ($searchTerm) {
    $conditions[] = "events.title LIKE :search OR events.description LIKE :search";
    $stmt->bindValue(':search', "%$searchTerm%");
}

$results = $queryBuilder->selectWithJoin(
    'events',
    'events.*, COUNT(event_attendees.id) as attendee_count',
    $joins,
    $conditions,
    $limit,
    $offset,
    'events.event_date DESC'
);

echo json_encode(['data' => $results]);
