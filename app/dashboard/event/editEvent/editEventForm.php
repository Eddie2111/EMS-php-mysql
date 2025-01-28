<?php
include_once __DIR__ . '/../../../common/db/queryBuilder.php';

$eventId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$eventId) {
    die('Event ID is required.');
}

$event = $queryBuilder->select('Event', '*', ['id' => $eventId]);

if (empty($event)) {
    die('Event not found.');
}

$event = $event[0];

?>

<style>
    #eventModal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 99999;
    }

    #eventModal.active {
        display: block !important;
    }

    #modalContent {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        width: 90%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>

<button class="btn btn-primary" id="openEventModalBtn">Edit Your Event</button>


<div id="eventModal">
    <div id="modalContent">
        <div class="modal-header">
            <h2>Edit Event</h2>
            <button class="close-btn" id="closeModalBtn">&times;</button>
        </div>
        <form action="/dashboard/event/editEvent/editEventForm.action.php" method="POST" class="text-start">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($eventId); ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($event['description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="datetime-local" class="form-control" id="startDate" name="startDate" value="<?php echo date('Y-m-d\TH:i', strtotime($event['startDate'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="datetime-local" class="form-control" id="endDate" name="endDate" value="<?php echo date('Y-m-d\TH:i', strtotime($event['endDate'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo htmlspecialchars($event['capacity'] ?? ''); ?>">
            </div>
            <div class="d-flex flex-row justify-content-between gap-2">
                <button type="button" class="w-100 btn btn-danger" id="deleteEventBtn" name="delete">Delete Event</button>
                <button type="submit" class="w-100 btn btn-success">Edit Event</button>
            </div>
        </form>
    </div>
</div>

<script src="./editEvent/editEventForm.script.js"></script>
<script src="./editEvent/editEventForm.helper.js"></script>