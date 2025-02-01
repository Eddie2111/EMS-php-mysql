<?php
include_once __DIR__ . '/../../../common/db/queryBuilder.php';
include_once __DIR__ . '/../../../common/db/tables.php';
include_once __DIR__ . '/../../../common/components/toast.php';

$eventId = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$eventId) {
    die('Event ID is required.');
}

$event = $queryBuilder->select(EVENTS_TABLE, '*', ['id' => $eventId]);
if (empty($event)) {
    die('Event not found.');
}
$event = $event[0];

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

$attended = $queryBuilder->select(ATTENDEES_TABLE, '*', [
    'eventId' => $eventId,
    'userId' => $userId
]);

$buttonText = !empty($attended) ? 'Cancel Join' : 'Join Event';
$buttonClass = !empty($attended) ? 'btn-danger' : 'btn-success';
$apiEndpoint = !empty($attended)
    ? 'http://localhost:8080/api/server.php/events/unregister'
    : 'http://localhost:8080/api/server.php/events/register';
$apiMethod = !empty($attended) ? 'PATCH' : 'POST';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Button to Open Modal -->
<button class="btn btn-primary" id="openEventModalBtn" data-bs-toggle="modal" data-bs-target="#eventModal">
    <?php echo $buttonText; ?>
</button>

<!-- Modal -->
<div class="fade modal" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Join this event?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="mt-3 table-bordered table">
                    <tbody>
                        <tr>
                            <th class="text-end">Title:</th>
                            <td><?php echo htmlspecialchars($event['title']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-end">Description:</th>
                            <td><?php echo htmlspecialchars($event['description'] ?? 'No description available.'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-end">Start:</th>
                            <td><?php echo date('Y-m-d H:i', strtotime($event['startDate'])); ?></td>
                        </tr>
                        <tr>
                            <th class="text-end">End:</th>
                            <td><?php echo date('Y-m-d H:i', strtotime($event['endDate'])); ?></td>
                        </tr>
                        <tr>
                            <th class="text-end">Location:</th>
                            <td><?php echo htmlspecialchars($event['location'] ?? 'No location specified.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn <?php echo $buttonClass; ?>" id="actionButton">
                    <?php echo $buttonText; ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Component -->
<?php renderToast(); ?>

<script>
    async function handleApiCall(url, method, body) {
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'An error occurred');
            }

        
            showToast(data.message || 'Operation successful');

        
            closeAndResetModal();

        
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } catch (error) {
        
            showToast(error.message || 'An unexpected error occurred');
        }
    }


    function closeAndResetModal() {
        const modalElement = document.getElementById('eventModal');
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
        }

        modalElement.classList.remove('show');
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }

        modalElement.style.display = 'none';
    }

    document.getElementById("actionButton").addEventListener("click", function() {
        handleApiCall(
            '<?php echo $apiEndpoint; ?>',
            '<?php echo $apiMethod; ?>', {
                eventId: <?php echo $eventId; ?>
            }
        );
    });
</script>