<?php
include_once __DIR__ . "/../../../common/headers/index.php";

include __DIR__ . "/../../../common/guards/auth.guard.php";
include __DIR__ . "/../../../common/components/toast.php";
require __DIR__ . '/../../../common/db/queryBuilder.php';
require __DIR__ . '/../../../common/db/tables.php';

phpHead(
    $title = "Admin | Events List",
    $description = "admin list view",
    $keywords = "admin list view"
);

include __DIR__ . "/../../../common/components/navbar.php";

$eventsWithAttendees = $queryBuilder->selectWithJoin(
    'Event',
    'Event.id, Event.title, Event.capacity, COUNT(Attendee.id) AS attendeeCount, User.name AS creatorName',
    [
        [
            'type' => 'LEFT',
            'table' => 'Attendee',
            'on' => 'Event.id = Attendee.eventId'
        ],
        [
            'type' => 'LEFT',
            'table' => 'User',
            'on' => 'Event.creatorId = User.id'
        ]
    ],
    [],
    null,
    null,
    'Event.id ASC',
    'Event.id, Event.title, Event.capacity, User.name'
);
?>

<div class="mt-4 container">
    <h2 class="mb-4">List View</h2>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Participant Limit</th>
                    <th scope="col">Event Creator</th>
                    <th scope="col">Seats Remaining</th>
                    <th scope="col">Attendee List</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($eventsWithAttendees)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No events found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($eventsWithAttendees as $index => $event): ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= $event['capacity'] ?? 'Unlimited' ?></td>
                            <td><?= htmlspecialchars($event['creatorName']) ?></td>
                            <td><?= isset($event['capacity']) ? max(0, $event['capacity'] - $event['attendeeCount']) : 'Unlimited' ?></td>
                            <td>
                                <button class="btn btn-primary download-btn" data-event-id="<?= $event['id'] ?>">Download</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".download-btn").forEach(button => {
            button.addEventListener("click", function() {
                const eventId = this.getAttribute("data-event-id");
                if (eventId) {
                    const url = `http://localhost:8080/api/server.php/events/attendees/download?eventId=${eventId}`;

                    const a = document.createElement("a");
                    a.href = url;
                    a.target = "_blank";
                    a.click();
                } else {
                    console.error("Event ID is missing.");
                }
            });
        });
    });
</script>