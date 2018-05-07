<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	include("../methods.php");
	$confFile = "../settings.conf.php";
	if (setupCheck($confFile)) {
		die("exists");
	}
	$configVals = readGameConfig($_POST['congLocation']);
	$jsonPath = pathinfo($_POST['congLocation'])['dirname'] . "\\" . str_ireplace("/", "\\", $configVals['Server.VotingJsonPath']);
	$savestr = "<?php\n";
	$savestr .= '$CONF_location = "' . str_replace("\\", "\\\\", $_POST['congLocation']) . "\";\n";
	$savestr .= '$MYSQL_Host = "' . $_POST['sqlhost'] . "\";\n";
	$savestr .= '$MYSQL_Username = "' . $_POST['sqluname'] . "\";\n";
	$savestr .= '$MYSQL_Password = "' . $_POST['sqlpword'] . "\";\n";
	$savestr .= '$MYSQL_DB = "' . $_POST['sqldb'] . "\";\n";
	$savestr .= '$VOTING_location = "' . str_replace("\\", "\\\\", $jsonPath) . "\";\n";
	$savestr .= "?>";
	file_put_contents($confFile, $savestr) or die("error1");
	//usleep(2000000);
	
	if (!CreateUserTableInst($_POST['sqlhost'], $_POST['sqluname'], $_POST['sqlpword'], $_POST['sqldb'])) die("error3");
	if (!CreateUserInst($_POST['uname'], $_POST['pword'], $_POST['sqlhost'], $_POST['sqluname'], $_POST['sqlpword'], $_POST['sqldb'])) die("error2");
	if (!CreateRconTableInst($_POST['sqlhost'], $_POST['sqluname'], $_POST['sqlpword'], $_POST['sqldb'])) die("error4");
	
	$_SESSION['uName'] = $_POST['uname'];
	$_SESSION['hash'] = GetHashInst($_POST['uname'],$_POST['sqlhost'], $_POST['sqluname'], $_POST['sqlpword'], $_POST['sqldb']);
	echo "success";
?>