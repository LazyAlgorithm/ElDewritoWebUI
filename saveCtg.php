<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	$confFile = "settings.conf.php";
	include($confFile);
	include("methods.php");
	//die(setupCheck($confFile));
	
	$filename = $CONF_location;
	
	$handle = fopen($filename, "r");
	$config = fread($handle, filesize($filename));
	fclose($handle);
	
	$configVals = readGameConfig($filename);
	
	$config = str_replace("Server.Name \"" . rtrim($configVals["Server.Name"]) . "\"", "Server.Name \"" . $_POST['servername'] . "\"", $config);
	$config = str_replace("Server.Message \"" . rtrim($configVals["Server.Message"]) . "\"", "Server.Message \"" . $_POST['servermess'] . "\"", $config);
	$config = str_replace("Server.MaxPlayers \"" . rtrim($configVals["Server.MaxPlayers"]) . "\"", "Server.MaxPlayers \"" . $_POST['maxplayers'] . "\"", $config);
	$config = str_replace("Server.SprintEnabled \"" . rtrim($configVals["Server.SprintEnabled"]) . "\"", "Server.SprintEnabled \"" . ischecked('sprint') . "\"", $config);
	$config = str_replace("Server.HitMarkersEnabled \"" . rtrim($configVals["Server.HitMarkersEnabled"]) . "\"", "Server.HitMarkersEnabled \"" . ischecked('hitmrkr') . "\"", $config);
	$config = str_replace("Server.BottomlessClipEnabled \"" . rtrim($configVals["Server.BottomlessClipEnabled"]) . "\"", "Server.BottomlessClipEnabled \"" . ischecked('bottomClip') . "\"", $config);
	$config = str_replace("Server.UnlimitedSprint \"" . rtrim($configVals["Server.UnlimitedSprint"]) . "\"", "Server.UnlimitedSprint \"" . ischecked('UnlimitedSprint') . "\"", $config);
	$config = str_replace("Server.DualWieldEnabled \"" . rtrim($configVals["Server.DualWieldEnabled"]) . "\"", "Server.DualWieldEnabled \"" . ischecked('duelWield') . "\"", $config);
	$config = str_replace("Server.AssassinationEnabled \"" . rtrim($configVals["Server.AssassinationEnabled"]) . "\"", "Server.AssassinationEnabled \"" . ischecked('assassinarion') . "\"", $config);
	$config = str_replace("Server.VotingEnabled \"" . rtrim($configVals["Server.VotingEnabled"]) . "\"", "Server.VotingEnabled \"" . ischecked('voting') . "\"", $config);
	$config = str_replace("Server.MapVotingTime \"" . rtrim($configVals["Server.MapVotingTime"]) . "\"", "Server.MapVotingTime \"" . $_POST['votingTime'] . "\"", $config);
	$config = str_replace("Server.NumberOfRevotesAllowed \"" . rtrim($configVals["Server.NumberOfRevotesAllowed"]) . "\"", "Server.NumberOfRevotesAllowed \"" . $_POST['revoteMax'] . "\"", $config);
	$config = str_replace("Server.NumberOfVotingOptions \"" . rtrim($configVals["Server.NumberOfVotingOptions"]) . "\"", "Server.NumberOfVotingOptions \"" . $_POST['votingOptions'] . "\"", $config);
	$config = str_replace("Server.VetoSystemEnabled \"" . rtrim($configVals["Server.VetoSystemEnabled"]) . "\"", "Server.VetoSystemEnabled \"" . ischecked('vetoing') . "\"", $config);
	$config = str_replace("Server.VetoVoteTime \"" . rtrim($configVals["Server.VetoVoteTime"]) . "\"", "Server.VetoVoteTime \"" . $_POST['vetoingTime'] . "\"", $config);
	$config = str_replace("Server.NumberOfVetoVotes \"" . rtrim($configVals["Server.NumberOfVetoVotes"]) . "\"", "Server.NumberOfVetoVotes \"" . $_POST['vetoAmt'] . "\"", $config);
	$config = str_replace("Server.VetoWinningOptionShownTime \"" . rtrim($configVals["Server.VetoWinningOptionShownTime"]) . "\"", "Server.VetoWinningOptionShownTime \"" . $_POST['vetoTime'] . "\"", $config);
	$config = str_replace("Server.VetoVotePassPercentage \"" . rtrim($configVals["Server.VetoVotePassPercentage"]) . "\"", "Server.VetoVotePassPercentage \"" . $_POST['vetoPerc'] . "\"", $config);
	$config = str_replace("Server.VotePassPercentage \"" . rtrim($configVals["Server.VotePassPercentage"]) . "\"", "Server.VotePassPercentage \"" . $_POST['votePerc'] . "\"", $config);
	//echo  ischecked('sprint');
      
	  function ischecked($val)
	  {
		if (!empty($_POST[$val]))
			return 1;
		else
			return 0;
	  }
	
	//$maxPlayers = str_replace('Server.MaxPlayers "', '', $configArray[41]);
	//$serverMessage = str_replace('Server.Message "', '', $configArray[37]);
	//$sprint = str_replace('Server.SprintEnabled "', '', $configArray[47]);
	//$hitmrkr = str_replace('Server.HitMarkersEnabled "', '', $configArray[48]);
	//$bottomClip = str_replace('Server.BottomlessClipEnabled "', '', $configArray[49]);
	//$UnlimitedSprint = str_replace('Server.UnlimitedSprint "', '', $configArray[50]);
	//$duelWield = str_replace('Server.DualWieldEnabled "', '', $configArray[51]);
	//$assassinarion = str_replace('Server.AssassinationEnabled "', '', $configArray[52]);
	//$voting = str_replace('Server.VotingEnabled "', '', $configArray[61]);
	//$votingTime = str_replace('Server.MapVotingTime "', '', $configArray[62]);
	//$revoteMax = str_replace('Server.NumberOfRevotesAllowed "', '', $configArray[63]);
	//$votingOptions = str_replace('Server.NumberOfVotingOptions "', '', $configArray[64]);
	//$vetoingOptions = str_replace('Server.VetoSystemEnabled "', '', $configArray[79]);
	//$vetoingTime = str_replace('Server.VetoVoteTime "', '', $configArray[81]);
	
	file_put_contents($filename, $config) or die("Unable to save Config");
	echo "Config Saved!";
 ?>