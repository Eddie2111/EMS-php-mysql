const form = document.getElementById('registrationForm');
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const name_1 = document.getElementById('name');
const submitBtn = document.getElementById('submitBtn');

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validateName(name) {
    const nameRegex = /^[a-zA-Z0-9 ]{2,32}$/;
    return nameRegex.test(name);
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

    if (password.value !== confirmPassword.value) {
        confirmPassword.classList.remove('is-valid');
        confirmPassword.classList.add('is-invalid');
        confirmPassword.nextElementSibling.style.display = 'block'; 
        isValid = false;
    } else {
        confirmPassword.classList.remove('is-invalid');
        confirmPassword.classList.add('is-valid');
        confirmPassword.nextElementSibling.style.display = 'none';
    }

    if (name_1.value.trim() !== '' && !validateName(name_1.value)) {
        name_1.classList.remove('is-valid');
        name_1.classList.add('is-invalid');
        isValid = false;
    } else if (name_1.value.trim() !== '') {
        name_1.classList.remove('is-invalid');
        name_1.classList.add('is-valid');
    }

    submitBtn.disabled = !isValid;

    return isValid;
}

email.addEventListener('input', validateForm);
password.addEventListener('input', validateForm);
confirmPassword.addEventListener('input', validateForm);
name.addEventListener('input', validateForm);

form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!validateForm()) {
        return;
    }
    form.submit();
});