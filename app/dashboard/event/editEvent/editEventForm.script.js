document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openEventModalBtn');
    const modal = document.getElementById('eventModal');
    const closeBtn = document.getElementById('closeModalBtn');
    const deleteBtn = document.getElementById('deleteEventBtn');

    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    deleteBtn.addEventListener('click', function (e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = '/dashboard/event/editEvent/deleteEvent.action.php';

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = document.querySelector('input[name="id"]').value;

            deleteForm.appendChild(idInput);
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        }
    });
});
