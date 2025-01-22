<?php
/*
TODO-> create data 

$data = [
    'name' => 'Tech Conference',
    'description' => 'A conference about technology.',
    'max_capacity' => 100
];

$queryBuilder->insert('events', $data);

TODO -> find data

$conditions = ['id' => 1];
$events = $queryBuilder->select('events', '*', $conditions);

print_r($events);

TODO -> update data

$data = ['name' => 'Updated Conference'];
$conditions = ['id' => 1];

$queryBuilder->update('events', $data, $conditions);


TODO -> delete data

$conditions = ['id' => 1];

$queryBuilder->delete('events', $conditions);


TODO -> join data

$joins = [
    [
        'type' => 'INNER',        // Join type (INNER, LEFT, RIGHT, etc.)
        'table' => 'attendees',  // Table to join
        'on' => 'events.id = attendees.event_id'  // Join condition
    ]
];

$conditions = ['events.id' => 1];

$results = $queryBuilder->selectWithJoin('events', 'events.name, attendees.name as attendee_name', $joins, $conditions);

print_r($results);


TODO -> transaction

try {
    $queryBuilder->beginTransaction();

    // Insert an event
    $eventData = [
        'name' => 'Tech Conference',
        'description' => 'A conference about tech.',
        'max_capacity' => 200
    ];
    $queryBuilder->insert('events', $eventData);

    // Get the last inserted event ID
    $eventId = $pdo->lastInsertId();

    // Insert attendees
    $attendeeData1 = ['event_id' => $eventId, 'name' => 'John Doe'];
    $attendeeData2 = ['event_id' => $eventId, 'name' => 'Jane Smith'];

    $queryBuilder->insert('attendees', $attendeeData1);
    $queryBuilder->insert('attendees', $attendeeData2);

    // Commit the transaction
    $queryBuilder->commit();
    echo "Event and attendees added successfully!";
} catch (Exception $e) {
    // Rollback the transaction on error
    $queryBuilder->rollBack();
    echo "Failed to add event and attendees: " . $e->getMessage();
}


*/
?>