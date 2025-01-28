<!DOCTYPE html>
<html lang="en">

<?php include_once('../common/headers/index.php');
phpHead(
    $title = "register",
    $description = "register from here",
    $keywords = "register, authentication, secure register",
    $extraMeta = `<link rel="stylesheet" href="./register.style.css">`,
);
?>

<body>
    <?php
    include("../common/components/navbar.php");
    ?>
    <div class="mt-5 container">
        <div class="justify-content-center row">
            <div class="col-md-6">
                <div class="shadow card">
                    <div class="card-body">
                        <h2 class="text-center card-title">Registration</h2>
                        <form id="registrationForm" action="register.action.php" method="POST" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Please enter a password.</div>
                            </div>

                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPassword" required>
                                <div class="invalid-feedback">Passwords do not match.</div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <div class="valid-feedback">Name is valid.</div>
                                <div class="invalid-feedback">Name must be alphanumeric and less than 32 characters.</div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>

                            <div class="d-grid"><button id="submitBtn" type="submit" class="btn btn-primary" disabled>Register</button></div>
                        </form>
                    </div>
                    <p class="mt-2 text-center">
                        <span>Have account?</span>
                        <a href="/login/">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="./register.script.js"></script>

</body>

</html>