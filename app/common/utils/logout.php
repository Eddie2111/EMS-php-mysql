<?php
session_start();

setcookie('token', '', time() - 3600, '/', '', true, true);
session_unset();
session_destroy();

header("Location: /login.php?message=Logged+out+successfully.");
exit();
