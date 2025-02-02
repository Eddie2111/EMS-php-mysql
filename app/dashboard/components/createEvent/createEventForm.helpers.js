document.addEventListener('DOMContentLoaded', () => {
    const title = document.getElementById('title');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const capacity = document.getElementById('capacity');

    [title, startDate, endDate, capacity].forEach((input) => {
        input.addEventListener('input', () => validateInput(input));
    });

    function validateInput(input) {
        clearError(input);

        if (input.id === 'title') {
            if (input.value.trim() === '') {
                showError(input, 'Title is required.');
            } else if (input.value.length > 100) {
                showError(input, 'Title must not exceed 100 characters.');
            } else {
                markValid(input);
            }
        }

        if (input.id === 'startDate' || input.id === 'endDate') {
            if (startDate.value && endDate.value) {
                const startISO = new Date(startDate.value).toISOString();
                const endISO = new Date(endDate.value).toISOString();

                if (startISO >= endISO) {
                    showError(endDate, 'End time must be later than start time.');
                    return;
                } else {
                    markValid(startDate);
                    markValid(endDate);
                }
            }

            if (input.value === '') {
                showError(input, `${input.id === 'startDate' ? 'Start time' : 'End time'} is required.`);
            }
        }

        if (input.id === 'capacity') {
            if (input.value === '') {
                showError(input, 'Capacity is required.');
            } else if (parseInt(input.value) <= 0 || isNaN(parseInt(input.value))) {
                showError(input, 'Capacity must be a positive number.');
            } else if (parseInt(input.value) > 10000) {
                showError(input, 'Capacity cannot exceed 100,000.');
            } else {
                markValid(input);
            }
        }
    }

    function markValid(input) {
        input.style.border = '2px solid green';
    }

    function showError(input, message) {
        let error = input.parentNode.querySelector('.error-message');
        if (!error) {
            error = document.createElement('div');
            error.className = 'error-message';
            error.style.color = 'red';
            error.style.fontSize = '0.9rem';
            error.style.marginTop = '5px';
            input.parentNode.appendChild(error);
        }
        error.textContent = message;
        input.style.border = '2px solid red';
    }

    function clearError(input) {
        input.style.border = '';
        const error = input.parentNode.querySelector('.error-message');
        if (error) error.remove();
    }

    document.querySelector('form').addEventListener('submit', (e) => {
        const inputs = [title, startDate, endDate, capacity];
        let hasErrors = false;

        inputs.forEach((input) => {
            validateInput(input);
            if (input.parentNode.querySelector('.error-message')) {
                hasErrors = true;
            }
        });

        if (hasErrors) {
            e.preventDefault();
        }
    });
});