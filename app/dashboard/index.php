<?php
session_start();

include("../common/guards/auth.guard.php");
include "../common/headers/index.php";
include("../common/components/toast.php");

try {
    $userId = verifyJWT();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /login/");
    exit;
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<?php
phpHead(
    $title = "Dashboard",
    $description = "Dashboard from here",
    $keywords = "Dashboard, authentication, secure login"
);
renderToast($message);
?>

<?php
include("../common/components/navbar.php");
?>

<?php
include("./components/eventsContainer/index.php");
?>