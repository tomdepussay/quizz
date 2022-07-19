<?php
session_start();
session_destroy();
setcookie('LOGGED_USER', '', time() - 1 );
header('Location: index.php');
exit;
?>