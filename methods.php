<?php
	//
	
	include("settings.conf.php");
	function CheckLogin($username, $password) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
	
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . strtolower($username) . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $salt, $level);
		
		$success = 0;
		while ($stmt->fetch()) {
			$passwordHash = GenerateHash($password, $salt);
			if ($passwordHash == $dppass) {
				$success = 1;
			}
		}
		
		$mysqli->close();
		return $success;
	}
	
	function CheckLoginHash($username, $password) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
	
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . strtolower($username) . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $salt, $level);
		
		$success = 0;
		while ($stmt->fetch()) {
			if ($password == $dppass) {
				$success = 1;
			}
		}
		
		$mysqli->close();
		return $success;
	}
	
	function GenerateSalt() {
		return substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-={}[]:;|\\<,>.?/",5)),0,rand(4,6));
	}

	function CreateUser($username, $password) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		
		$stmt = $mysqli->prepare("INSERT INTO users (username, login, password, salt, level) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssi', $uname, $login, $hash, $salt, $level);
		
		$saltTmp = GenerateSalt();
		$uname = $username;
		$login = strtolower($username);
		$hash = GenerateHash($password, $saltTmp);
		$salt = $saltTmp;
		$level = "0";
		
		if ($stmt->execute()) {
			$mysqli->close();
			return 1;
		}
		else {
			$mysqli->close();
			return 0;
		}
	}
	
	function CreateUserInst($username, $password, $MYSQL_Host, $MYSQL_Username, $MYSQL_Password, $MYSQL_DB) {
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		
		$stmt = $mysqli->prepare("INSERT INTO users (username, login, password, salt, level) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssi', $uname, $login, $hash, $salt, $level);
		
		$saltTmp = GenerateSalt();
		$uname = $username;
		$login = strtolower($username);
		$hash = GenerateHash($password, $saltTmp);
		$salt = $saltTmp;
		$level = "0";
		
		if ($stmt->execute()) {
			$mysqli->close();
			return 1;
		}
		else {
			$mysqli->close();
			return 0;
		}
	}
	
	function CreateUserTable() {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$sql = "CREATE TABLE IF NOT EXISTS users (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		username text NOT NULL,
		login text NOT NULL,
		password text NOT NULL,
		salt text NOT NULL,
		level int NOT NULL
		)";
		
		if ($mysqli->query($sql) === TRUE) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function CreateUserTableInst($MYSQL_Host, $MYSQL_Username, $MYSQL_Password, $MYSQL_DB) {
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$sql = "CREATE TABLE IF NOT EXISTS users (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		username text NOT NULL,
		login text NOT NULL,
		password text NOT NULL,
		salt text NOT NULL,
		level int NOT NULL
		)";
		
		if ($mysqli->query($sql) === TRUE) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function CreateRconTable() {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$sql = "CREATE TABLE IF NOT EXISTS rconHosts (
		id INT AUTO_INCREMENT PRIMARY KEY , 
		name TEXT NOT NULL ,
		host TEXT NOT NULL ,
		port TEXT NOT NULL , 
		password TEXT NOT NULL 
		)";
		
		if ($mysqli->query($sql) === TRUE) {
			return 1;
		} else {
			return 0;
		}
	}
	
		function CreateRconTableInst($MYSQL_Host, $MYSQL_Username, $MYSQL_Password, $MYSQL_DB) {
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$sql = "CREATE TABLE IF NOT EXISTS rconHosts (
		id INT AUTO_INCREMENT PRIMARY KEY , 
		name TEXT NOT NULL ,
		host TEXT NOT NULL ,
		port TEXT NOT NULL , 
		password TEXT NOT NULL 
		)";
		
		if ($mysqli->query($sql) === TRUE) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function GenerateHash($info, $salt) {
		return MD5(MD5($salt) . MD5($info));
	}
	
	function GetIdFromUsername($username) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE username=\"" . $username . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $dbsalt, $level);
			
		while ($stmt->fetch()) {
			return $id;
		}
		$mysqli->close();
	}
	
	function GetUsernameFromLogin($login) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . $login . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $dbsalt, $level);
			
		while ($stmt->fetch()) {
			return $name;
		}
		$mysqli->close();
	}
	
	function GetUserPermission($login) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . $login . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $dbsalt, $level);
			
		while ($stmt->fetch()) {
			return $level;
		}
		$mysqli->close();
	}
	
	function GetHash($username) {
		global $MYSQL_Host;
		global $MYSQL_Username;
		global $MYSQL_Password;
		global $MYSQL_DB;
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . strtolower($username) . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $dbsalt, $level);
			
		while ($stmt->fetch()) {
			return $dppass;
		}
		$mysqli->close();
	}
	
	function GetHashInst($username, $MYSQL_Host, $MYSQL_Username, $MYSQL_Password, $MYSQL_DB) {
		$mysqli = new mysqli($MYSQL_Host,$MYSQL_Username,$MYSQL_Password,$MYSQL_DB);
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE login=\"" . strtolower($username) . "\"");
		$stmt->execute();
		$stmt->bind_result($id, $name, $login, $dppass, $dbsalt, $level);
			
		while ($stmt->fetch()) {
			return $dppass;
		}
		$mysqli->close();
	}
	
	function is_localhost() {
		$whitelist = array( '127.0.0.1', '::1' );
		return in_array( $_SERVER['REMOTE_ADDR'], $whitelist);
	}
	
	function getHost() {
		if (is_localhost())
			return "localhost";
		else
			return gethostbyname($_SERVER['HTTP_HOST']);
	}
	
	function readGameConfig($confFile){
		$confHandle = fopen($confFile, "r");
		$configInfo = fread($confHandle, filesize($confFile));
		fclose($confHandle);
		$configArray = explode("\n", $configInfo);
		$configVals = [];
		foreach ($configArray as &$var){
			$info = explode(" ", $var);
			if (count($info) > 1)
			{
				$val = $info[1];
				foreach ($info as &$space)
				{
					if ($space != $info[0] && $space != $info[1])
					$val = $val . " " . $space;
				}
				$configVals[addslashes($info[0])] = str_replace('"', '', rtrim($val));
			}
		}
		return $configVals;
	}
	
	function getChecked($val) {
		$rtn = "";
		if ($val == 1)
			$rtn = "checked";
		return $rtn;
	}
	
	function setupCheck($CONF_location) {
		global $CONF_location;
		if ($CONF_location == "") {
			return 0;
		}
		else return 1;
	}
	
	function loadVotingJson() {
		global $VOTING_location;
		$jsonHandle = fopen($VOTING_location, "r");
		$jsonInfo = fread($jsonHandle, filesize($VOTING_location));
		return json_decode($jsonInfo, true);
	}
	
	function isMapInVoting($varray, $mapname) {
		$rtn = 0;
		foreach ($varray['Maps'] as &$map)
		{
			if ($map['mapName'] == $mapname)
				return 1;
		}
		return $rtn;
	}
	
	function array2string($data, $level=0){
		$log_a = "";
		foreach ($data as $key => $value) {
			if(is_array($value))    $log_a .= str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level) . "[".$key."] => <br/>" . str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level) .  "{<br/>". array2string($value, $level + 1). str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level) .  "} <br/>";
			else                    $log_a .= str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level) .  "[".$key."] => ".$value."<br/>";
		}
		return $log_a;
	}
?>