<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	include("methods.php");
	if (CheckLoginHash($_SESSION['uName'], $_SESSION['hash']) != 1) die(0);
	
	
	$confFile = "settings.conf.php";
	include($confFile);
	$filename = $CONF_location;
	
	$configVals = readGameConfig($filename);
	
	echo getHost() . "::" . $configVals["Game.RconPort"] . "::" . $configVals["Server.RconPassword"];
?>