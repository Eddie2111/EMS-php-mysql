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
    confirmBtn.addEventListener('click', async function () {
        try {
            confirmBtn.disabled = true;
            const token = localStorage.getItem('token'); // Assuming token is stored in localStorage

            if (!token) {
                throw new Error('Please log in to join events');
            }

            const response = await fetch('/api/events/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ eventId: eventId })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Failed to join event');
            }

            showMessage('Successfully joined the event!');
            confirmBtn.style.display = 'none';
            closeBtn.textContent = 'Close';

            // Refresh the page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);

        } catch (error) {
            showMessage(error.message, true);
            confirmBtn.disabled = false;
        }
    });
});
