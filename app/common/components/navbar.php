<?php
include_once __DIR__ . '/../headers/index.php';
include_once __DIR__ . '/../utils/jwt.php';

function isLoggedIn()
{
    if (!isset($_COOKIE['token'])) {
        return false;
    }

    try {
        decodeJWT($_COOKIE['token'], JWT_SECRET);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>

<nav class="bg-body-tertiary navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="mb-2 mb-lg-0 me-auto navbar-nav">
                <li class="nav-item">
                    <a class="active nav-link" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="disabled nav-link" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isLoggedIn()): ?>
                    <a href="/common/utils/logout.php" class="btn btn-outline-danger">Logout</a>
                <?php else: ?>
                    <a href="/login.php" class="btn btn-outline-primary me-2">Login</a>
                    <a href="/signup.php" class="btn btn-outline-success">Signup</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>