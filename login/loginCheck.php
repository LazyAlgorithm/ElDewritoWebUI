<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	
	include("../methods.php");
	
	$username = $_POST['uname'];
	$pass = $_POST['pword'];
	
	if (strtolower($username) == "guest") {
		$pass = "guest";
	}
	$loginCheck = CheckLogin($username, $pass, "../");
	if ($loginCheck == 1) {
		echo (GetIdFromUsername($username, "../") . ":" . GetUsernameFromLogin($username, "../"));
		$_SESSION['uName'] = $username;
		$_SESSION['hash'] = GetHash($username, "../");
	}
	else {
		echo("false");
	}
?>