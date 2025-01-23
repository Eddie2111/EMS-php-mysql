<div class="container mt-5">
    <h1>Create a New Event</h1>
    <form action="./components/createEvent/createEventForm.action.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">End Date</label>
            <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity">
        </div>
        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>