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

<style>
    .nav-link.btn-outline-light:hover {
        color: #000 !important;
        background-color: #fff !important;
    }
</style>

<nav class="bg-primary navbar navbar-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fa-calendar-alt fas me-2"></i>EventFlow
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="ms-auto navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fa-home fas me-1"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/events.php"><i class="fa-calendar fas me-1"></i>Events</a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/"><i class="fa-tachometer-alt fas me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/create-event.php"><i class="fa-plus-circle fas me-1"></i>Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2 nav-link" href="/common/utils/logout.php">
                            <i class="fa-sign-out-alt fas me-1"></i>Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light me-2 nav-link" href="/login/">
                            <i class="fa-sign-in-alt fas me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light nav-link" href="/register/">
                            <i class="fa-user-plus fas me-1"></i>Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>