<?php
include_once __DIR__ . '/../../common/headers/index.php';
include __DIR__ . "/../../common/guards/auth.guard.php";
include __DIR__ . "/../../common/components/toast.php";
require __DIR__ . '/../../common/db/queryBuilder.php';
require __DIR__ . '/../../common/db/tables.php';
include __DIR__ . "/../../common/components/navbar.php";

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

$eventId = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$eventId) {
    die('Invalid Event ID.');
}

$event = $queryBuilder->select(EVENTS_TABLE, '*', ['id' => $eventId]);
if (empty($event)) {
    die('Event not found.');
}
$event = $event[0];

$user = $queryBuilder->select(USERS_TABLE, '*', ['id' => $event['creatorId']]);
if (!empty($user)) {
    $event['creator'] = $user[0];
}

$attendees = $queryBuilder->selectWithJoin(
    ATTENDEES_TABLE,
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

phpHead(
    "Event Details | " . htmlspecialchars($event['title']),
    "Discover more about " . htmlspecialchars($event['title']) . ": " . htmlspecialchars($event['description'] ?? 'Explore our event details.'),
    "event details, " . htmlspecialchars($event['title']) . ", events"
);
?>

<body>
    <div class="mt-5 container">
        <div class="card">
            <div class="bg-primary text-white card-header">
                <h2>Event Name: <?php echo htmlspecialchars($event['title']); ?></h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Created at: <?php echo date('F j, Y, g:i a', strtotime($event['createdAt'])); ?>
                </p>
                <p><strong>Description:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($event['description'] ?? 'No description provided.')); ?></p>
                <p><strong>Start Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($event['startDate'])); ?></p>
                <p><strong>End Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($event['endDate'])); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location'] ?? 'Not specified.'); ?></p>
                <p><strong>Capacity:</strong> <?php echo $event['capacity'] ?? 'No limit'; ?></p>
                <p><strong>Created by:</strong> <?php echo htmlspecialchars($event['creator']['name'] ?? 'Unknown'); ?></p>
                <p><strong>Registered Attendees:</strong> <?php echo count($attendees); ?></p>
            </div>

            <br /><br /><br />

            <div class="text-end card-footer">
                <?php if ($userId === $event['creatorId']) : ?>
                    <?php include("./editEvent/editEventForm.php"); ?>
                <?php endif; ?>
                <?php if ($userId !== $event['creatorId']) : ?>
                    <?php include("./joinEvent/joinEventForm.php"); ?>
                <?php endif; ?>
                <a href="/dashboard/" class="btn btn-secondary">Back to Events</a>
            </div>
        </div>

        <?php if ($isAdmin) : ?>
            <div class="mt-3 card">
                <div class="bg-primary text-white card-header">
                    <h3>Registered Attendees</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($attendees)) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendees as $attendee) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($attendee['name'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($attendee['email'] ?? 'N/A'); ?></td>
                                        <td><?php echo date('F j, Y, g:i a', strtotime($attendee['registeredAt'] ?? 'N/A')); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p class="text-center">No one has registered for this event yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>