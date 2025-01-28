document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openEventModalBtn');
const modal = document.getElementById('eventModal');
const closeBtn = document.getElementById('closeModalBtn');

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
});