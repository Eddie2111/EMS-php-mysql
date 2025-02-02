const form = document.getElementById('loginForm');
const email = document.getElementById('email');
const password = document.getElementById('password');
const submitBtn = document.getElementById('submitBtn');

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validateForm() {
    let isValid = true;

    if (!validateEmail(email.value)) {
        email.classList.remove('is-valid');
        email.classList.add('is-invalid');
        email.nextElementSibling.style.display = 'block';
        isValid = false;
    } else {
        email.classList.remove('is-invalid');
        email.classList.add('is-valid');
        email.nextElementSibling.style.display = 'none';
    }

    if (password.value.trim() === '') {
        password.classList.remove('is-valid');
        password.classList.add('is-invalid');
        password.nextElementSibling.style.display = 'block';
        isValid = false;
    } else {
        password.classList.remove('is-invalid');
        password.classList.add('is-valid');
        password.nextElementSibling.style.display = 'none';
    }

    submitBtn.disabled = !isValid;

    return isValid;
}

email.addEventListener('input', validateForm);
password.addEventListener('input', validateForm);

form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!validateForm()) {
        return;
    }
    form.submit();
});