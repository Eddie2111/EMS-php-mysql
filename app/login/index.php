<!DOCTYPE html>
<html lang="en">

<?php
include_once('../common/headers/index.php');
include("../common/components/toast.php");
phpHead(
    $title = "Login",
    $description = "Login from here",
    $keywords = "login, authentication, secure login",
    $extraMeta = `<link rel="stylesheet" href="./login.style.css">`,
);
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
renderToast($message);
?>
<style>
    .body-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f8f9fa;
    }

    .card {
        width: 100%;
        max-width: 400px;
    }
</style>

<body>
    <?php
    include("../common/components/navbar.php");
    ?>
    <div class="body-container">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Login</h4>
                <form id="loginForm" action="login.action.php" method="POST" novalidate>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            required>
                        <div class="invalid-feedback">Please enter a valid email address. </div>
                    </div>
                    <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Enter your password"

                            required minlength="6">
                        <div class="invalid-feedback">Password must be at least 6 characters. </div>
                    </div>
                    <div class="d-grid"><button id="submitBtn" type="submit" class="btn btn-primary">Login</button></div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                const form = event.target;

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            });
        </script>
    </div>
</body>

</html>