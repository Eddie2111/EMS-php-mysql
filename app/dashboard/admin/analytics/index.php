<?php
include_once __DIR__ . "/../../../common/headers/index.php";
include __DIR__ . "/../../../common/guards/auth.guard.php";
include __DIR__ . "/../../../common/components/toast.php";
require __DIR__ . '/../../../common/db/queryBuilder.php';
require __DIR__ . '/../../../common/db/tables.php';

phpHead(
    $title = "Admin | Analytics",
    $description = "Admin analytics view",
    $keywords = "admin analytics view"
);

include __DIR__ . "/../../../common/components/navbar.php";

$eventsWithAttendees = $queryBuilder->selectWithJoin(
    'Event',
    'Event.id, Event.title, Event.capacity, COUNT(Attendee.id) AS attendeeCount',
    [
        [
            'type' => 'LEFT',
            'table' => 'Attendee',
            'on' => 'Event.id = Attendee.eventId'
        ]
    ],
    [],
    null,
    null,
    'Event.id ASC',
    'Event.id, Event.title, Event.capacity'
);
?>

<div class="mt-4 container">
    <h2 class="mb-4">Event Analytics</h2>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Participant Limit</th>
                    <th scope="col">Number of Attendees</th>
                    <th scope="col">Seats Remains</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($eventsWithAttendees)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No events found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($eventsWithAttendees as $index => $event): ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= $event['capacity'] ?? 'Unlimited' ?></td>
                            <td><?= $event['attendeeCount'] ?></td>
                            <td><?= $event['capacity'] - $event['attendeeCount'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>