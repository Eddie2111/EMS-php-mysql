<?php
session_start(); // Ensure session_start() is at the top.

include("../common/guards/auth.guard.php");
include "../common/headers/index.php";
include("../common/components/toast.php");

try {
    $userId = verifyJWT(); // Perform authentication first.
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

<h1>I was a guarded component! </h1>
<?php
include("./components/createEvent/creatEventForm.php");
?>
<?php
include("./components/eventsContainer/index.php");
?>