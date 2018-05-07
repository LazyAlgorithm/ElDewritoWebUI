<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
};
$_SESSION['uName'] = "";
$_SESSION['hash'] = "";
 session_destroy();
header('Location: login/index.php')
?>