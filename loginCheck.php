<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	
	include("methods.php");
	
	$username = $_POST['uname'];
	$pass = $_POST['pword'];
	
	if (CheckLogin($username, $pass) == 1) {
		echo (GetIdFromUsername($username) . ":" . GetUsernameFromLogin($username));
		$_SESSION['uName'] = $username;
		$_SESSION['hash'] = GetHash($username);
	}
	else {
		echo("false");
	}
?>