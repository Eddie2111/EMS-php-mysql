<link rel="stylesheet" href="./components/createEvent/createEventForm.style.css">

<div class="justify-content-end container">
    <button class="btn btn-primary" id="openEventModalBtn">+</button>
</div>

<div id="eventModal">
    <div id="modalContent">
        <div class="modal-header">
            <h2>Create a New Event</h2>
            <button class="close-btn" id="closeModalBtn">&times;</button>
        </div>
        <form action="./components/createEvent/createEventForm.action.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity">
            </div>
            <button type="submit" class="w-100 btn btn-success">Create Event</button>
        </form>
    </div>
</div>

<script src="./components/createEvent/createEventForm.script.js"></script>
<script src="./components/createEvent/createEventForm.helpers.js"></script>