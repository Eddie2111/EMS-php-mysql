<?php
session_start();

include __DIR__ . "/../../common/guards/auth.guard.php";
include __DIR__ . "/../../common/components/toast.php";

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

require __DIR__ . '/../../common/db/queryBuilder.php';
require __DIR__ . '/../../common/db/tables.php';

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
?>

<!DOCTYPE html>
<html lang="en">

<?php
include_once __DIR__ . '/../../common/headers/index.php';
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
            </div>
            <div class="text-end card-footer">
                <?php if ($userId === $event['creatorId']) : ?>
                    <!-- Include the Edit Event form if the authenticated user is the creator -->
                    <?php include("./editEvent/editEventForm.php"); ?>
                <?php endif; ?>
                <a href="/dashboard/" class="btn btn-secondary">Back to Events</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>