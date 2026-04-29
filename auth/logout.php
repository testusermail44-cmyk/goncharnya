<?php
session_start();
$_SESSION = [];
setcookie("remember_user", "", time() - 3600, "/");
session_destroy();
header("Location: ../pages/home.php");
exit();
?>
