<!DOCTYPE html>
<html lang="en">

<?php
include_once('../common/headers/index.php');
include("../common/components/toast.php");
phpHead(
    $title = "Login",
    $description = "Login from here",
    $keywords = "login, authentication, secure login",
    $extraMeta = "<link rel='stylesheet' href='./login.style.css' />",
);
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
renderToast($message);
?>


<body>
    <?php
    include("../common/components/navbar.php");
    ?>
    <div class="body-container">
        <div class="shadow card">
            <div class="card-body">
                <h4 class="mb-4 text-center card-title">Login</h4>
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
        <script src="./login.script.js"></script>
    </div>
</body>

</html>