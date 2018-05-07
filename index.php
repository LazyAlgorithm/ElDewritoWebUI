<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	include("methods.php");
	$confFile = "settings.conf.php";
	include($confFile);
	//die(setupCheck($confFile));
	if (!setupCheck($confFile)) header('Location: install/index.php');
	elseif (CheckLoginHash($_SESSION['uName'], $_SESSION['hash']) != 1) header('Location: login/index.php');
	
	$filename = $CONF_location;
	
	$configVals = readGameConfig($filename);
	
	//echo "</br></br>";
	//$filename = "C:\\games\\ElDewrito\\mods\\server\\voting.json";
	//$handle = fopen($filename, "r");
	//$json = fread($handle, filesize($filename));
	//fclose($handle);
	//echo '<pre>';
	//var_dump(json_decode($contents, true));
	//echo '</pre>';
	
	$jsonArray = loadVotingJson();
?>
<html>
	<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link href="css/base.css" rel="stylesheet">
	<link href="slider/css/slider.css" rel="stylesheet">
	<script type="text/javascript">
	</script>
	</head>
	<body>

      <!-- Fixed navbar -->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Halo Online</a>
		<button class="btn btn-outline-primary my-2 my-sm-0" type="submit"style="margin-right: 10px" onclick="window.location.replace('logout.php')">Logout</button>
	</nav>
	<div class="container-fluid">
      <div class="row">
        <nav  class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
				<span>Server Settings</span>
            </h6>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a data-div="congigMain" class="nav-link active" href="#">
                  <span data-feather="server"></span>
                  Server
                </a>
              </li>
              <li class="nav-item">
                <a data-div="voteMain" class="nav-link" href="#">
                  <span data-feather="code"></span>
                  Voting
                </a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="code"></span>
                  Veto
                </a>
              </li>-->
			</ul>
			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
				<span>RCON</span>
            </h6>
			<ul class="nav flex-column">
			  <li class="nav-item">
                <a data-div="rconMain" id="rconTabControl" class="nav-link" href="#">
                  <span data-feather="terminal"></span>
                  RCON Console
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main id="congigMain" role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<form id="ctgForm">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Server Config</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <button  class="btn btn-sm btn-outline-secondary btn-save" id="btn-save">
                <span data-feather="save"></span>
                Save Config
              </button>
            </div>
			
          </div>
		  <div class="mb-3">
              <label for="servername">Server Name</label>
              <input type="text" class="form-control" name="servername" id="servername" placeholder="Server Name" required="" value='<?php echo htmlspecialchars($configVals["Server.Name"], ENT_QUOTES);?>'>
			  <label for="servermess">Server Messge</label>
              <input type="text" class="form-control" name="servermess" id="servermess" placeholder="Server Message" required="" value='<?php	echo htmlspecialchars($configVals["Server.Message"], ENT_QUOTES);?>'>
			  <?php
			  
			  ?>
			  <br/><label for="maxplayers">Max Players: </label><span id="ex6SliderVal"><?php echo " " . $configVals["Server.MaxPlayers"]; ?></span><br/>
			  <input style="width: 100%;" name="maxplayers" id="maxplayers" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="16" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.MaxPlayers"];?>"/>
				
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h5">Server Traits</h1>
				</div>
				<?php
					
				?>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="sprint" id="sprint" <?php echo getChecked($configVals["Server.SprintEnabled"]); ?>>
				  <label class="form-check-label" for="sprint">
					Sprint Enabled.
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="hitmrkr" id="hitmrkr" <?php echo getChecked($configVals["Server.HitMarkersEnabled"]); ?>>
				  <label class="form-check-label" for="hitmrkr">
					Hit Markers
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="bottomClip" id="bottomClip" <?php echo getChecked($configVals["Server.BottomlessClipEnabled"]); ?>>
				  <label class="form-check-label" for="bottomClip">
					Bottomless Clip
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="UnlimitedSprint" id="UnlimitedSprint" <?php echo getChecked($configVals["Server.UnlimitedSprint"]); ?>>
				  <label class="form-check-label" for="bottomClip">
					Unlimited Sprint
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="duelWield" id="duelWield" <?php echo getChecked($configVals["Server.DualWieldEnabled"]); ?>>
				  <label class="form-check-label" for="duelWield">
					Duel Wielding
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" value="1" name="assassinarion" id="assassinarion" <?php echo getChecked($configVals["Server.AssassinationEnabled"]); ?>>
				  <label class="form-check-label" for="assassinarion">
					Assassination Enabled
				  </label>
				</div>
				
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h5">Server Voting</h1>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="voting" id="voting" <?php echo getChecked($configVals["Server.VotingEnabled"]); ?>>
						<label class="form-check-label" for="voting">
							Voting Enabled
						</label>
					</div>
				</div>
				<label for="votePerc">Votes Needed: </label><span id="votePercDis"><?php echo " " . $configVals["Server.VotePassPercentage"] . "%"; ?></span><br/>
				<input style="width: 100%;" name="votePerc" id="votePerc" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.VotePassPercentage"];?>"/>
				
				<label for="votingTime">Voting Time: </label><span id="maxVal"><?php echo " " . $configVals["Server.MapVotingTime"]; ?></span><br/>
				<input style="width: 100%;" name="votingTime" id="votingTime" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="60" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.MapVotingTime"];?>"/>
				
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="revoteMax">Re-votes Allowed: </label><span id="revoteAllowed"><?php echo " " . $configVals["Server.NumberOfRevotesAllowed"]; ?></span><br/>
						<input style="width: 100%;" name="revoteMax" name="revoteMax" id="revoteMax" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.NumberOfRevotesAllowed"];?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="votingOptions">Voting List Count: </label><span id="votingOptionCount"><?php echo " " . $configVals["Server.NumberOfVotingOptions"]; ?></span><br/>
						<input style="width: 100%;" name="votingOptions" id="votingOptions" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="4" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.NumberOfVotingOptions"];?>"/>
					</div>
				</div>
				
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h5">Server Vetoing</h1>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="" name="vetoing" id="vetoing" <?php echo getChecked($configVals["Server.VetoSystemEnabled"]); ?>>
						<label class="form-check-label" for="vetoing">
							Veto Enabled
						</label>
					</div>
				</div>
				
				<label for="vetoingTime">Vetoing Time: </label><span id="vetoTime"><?php echo " " . $configVals["Server.VetoVoteTime"]; ?></span><br/>
				<input style="width: 100%;" name="vetoingTime" id="vetoingTime" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="60" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.VetoVoteTime"];?>"/>
				<br/>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="vetoAmt">Vetos Needed: </label><span id="vetoAmtDis"><?php echo " " . $configVals["Server.NumberOfVetoVotes"]; ?></span><br/>
						<input style="width: 100%;" name="vetoAmt" id="vetoAmt" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="16" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.NumberOfVetoVotes"];?>"/>
					</div>
					<div class="col-md-6 mb-3">
						<label for="vetoTime">Vetoing List Count: </label><span id="vetoTimeDis"><?php echo " " . $configVals["Server.VetoWinningOptionShownTime"]; ?></span><br/>
						<input style="width: 100%;" name="vetoTime" id="vetoTime" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="60" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.VetoWinningOptionShownTime"];?>"/>
					</div>
				</div>
				
				<label for="vetoPerc">Vetos Needed: </label><span id="vetoPercDis"><?php echo " " . $configVals["Server.VetoVotePassPercentage"] . "%"; ?></span><br/>
				<input style="width: 100%;" name="vetoPerc" id="vetoPerc" data-slider-id='ex1Slider' class="slider" type="text" data-slider-min="1" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo $configVals["Server.VetoVotePassPercentage"];?>"/>
            </div>
			</form>
        </main>
		<main id="rconMain" role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="display:none;">
			<div class="pagination-centered text-center" style="width: 100%; height: 90%;" id="consoleContainer">
				<textarea id="messageLog" class="form-control BottomRadius" aria-label="With textarea" readonly></textarea>
				<div id="commandContainer" style="" class="input-group mb-3 ">
					<input type="text" id="rconCommand" class="form-control TopRadius" placeholder="RCON Command" aria-label="Recipient's username" aria-describedby="basic-addon2">
					<div class="input-group-append" style="border-radius: 0 !important">
						<button id="commandSubmit" class="btn btn-outline-secondary TopRadius" type="button">Send</button>
					</div>
				</div>
			</div>
		</main>
		<main id="voteMain" role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="display:none;">
		<form id="voteForm">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">Voting JSON</h1>
				<div class="btn-toolbar mb-2 mb-md-0">
					<button  class="btn btn-sm btn-outline-secondary btn-save" id="btn-save-voting">
						<span data-feather="save"></span>
						Save Voting
					</button>
				</div>
			</div>
			<div class="mb-3">
				<div class="container-fluid checkGroup" id="">
					<h1 class="h5 font-weight-normal">Default Maps Used</h1>
					<div class="spacer"></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Bunkerworld" id="Bunkerworld" <?php echo getChecked(isMapInVoting($jsonArray, "Bunkerworld")); ?>>
						<label class="form-check-label" for="Bunkerworld">
							Standoff
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Shrine" id="Shrine" <?php echo getChecked(isMapInVoting($jsonArray, "Shrine")); ?>>
						<label class="form-check-label" for="Shrine">
							Sandtrap
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="s3d_turf" id="s3d_turf" <?php echo getChecked(isMapInVoting($jsonArray, "s3d_turf")); ?>>
						<label class="form-check-label" for="s3d_turf">
							Icebox
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="s3d_reactor" id="s3d_reactor" <?php echo getChecked(isMapInVoting($jsonArray, "s3d_reactor")); ?>>
						<label class="form-check-label" for="s3d_reactor">
							Reactor
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Chill" id="Chill" <?php echo getChecked(isMapInVoting($jsonArray, "Chill")); ?>>
						<label class="form-check-label" for="Chill">
							Narrows
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Deadlock" id="Deadlock" <?php echo getChecked(isMapInVoting($jsonArray, "Deadlock")); ?>>
						<label class="form-check-label" for="Deadlock">
							High Ground
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Zanzibar" id="Zanzibar" <?php echo getChecked(isMapInVoting($jsonArray, "Zanzibar")); ?>>
						<label class="form-check-label" for="Zanzibar">
							Last Resort
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="riverworld" id="riverworld" <?php echo getChecked(isMapInVoting($jsonArray, "riverworld")); ?>>
						<label class="form-check-label" for="riverworld">
							Valhalla
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="Cyberdyne" id="Cyberdyne" <?php echo getChecked(isMapInVoting($jsonArray, "Cyberdyne")); ?>>
						<label class="form-check-label" for="Cyberdyne">
							The Pit
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="guardian" id="guardian" <?php echo getChecked(isMapInVoting($jsonArray, "guardian")); ?>>
						<label class="form-check-label" for="guardian">
							Guardian
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="s3d_avalanche" id="s3d_avalanche" <?php echo getChecked(isMapInVoting($jsonArray, "s3d_avalanche")); ?>>
						<label class="form-check-label" for="bottomClip">
							Diamondback
						</label>
					</div>
				</div><br/>
				<div class="container-fluid variantGroup" id="">
					<h1 class="h5 font-weight-normal">Variants Used</h1>
					<div  id="mapsListDiv" class="list-group list-group-flush addBorder">
						<div class="list-group-item disabled list-group-info">
							<div class="variantContent">Display Name</div>
							<div class="variantContent">Type Name</div>
							<div class="variantContent">Start Commands</div>
							<div class="variantContent">Specific Maps</div>
						</div>
						
<?php
$cnt = 0;
foreach ($jsonArray['Types'] as &$variant)
{
	$commandStr = '';
	foreach ($variant['commands'] as &$command) {
		if ($commandStr == '') $commandStr .= $command;
		else $commandStr .= "\n" . $command;
	}
	$mapsStr = '';
	foreach ($variant['SpecificMaps'] as &$map) {
		if ($mapsStr == '') $mapsStr .= $map['mapName'] . '=' . $map['displayName'];
		else $mapsStr .= "\n" . $map['mapName'] . '=' . $map['displayName'];
	}
	echo '<a id="variant' . $cnt . 'dis" href="#variant' . $cnt . '" data-toggle="collapse" aria-expanded="false" aria-controls="variant' . $cnt . '" class="list-group-item">' . "\n";
	echo '    <div class="variantContent" id="displayNameTop' . $cnt . '">' . $variant['displayName'] . '</div>' . "\n";
	echo '    <div class="variantContent" id="typeNameTop' . $cnt . '">' . $variant['typeName'] . '</div>' . "\n";
	echo '    <div class="variantContent" id="commandsTop' . $cnt . '">' . count($variant['commands']) . '</div>' . "\n";
	echo '    <div class="variantContent" id="mapsTop' . $cnt . '">' . count($variant['SpecificMaps']) . '</div>' . "\n";
	echo '</a>' . "\n";
	echo '<div class="container-fluid variantInfo collapse multi-collapse" id="variant' . $cnt . '">' . "\n";
	echo '    <div class="row">' . "\n";
	echo '        <div class="col-xs-6 col-sm-6 col-md-6">' . "\n";
	echo '            <div class="form-group">' . "\n";
	echo '                <label for="displayName' . $cnt . '">Display Name (Listed on Screen)</label>' . "\n";
	echo '                <input type="text" data-parant="displayNameTop' . $cnt . '" name="displayName' . $cnt . '" id="displayName' . $cnt . '" class="form-control input-sm" value="' . $variant['displayName'] . '" required>' . "\n";
	echo '            </div>' . "\n";
	echo '        </div>' . "\n";
	echo '        <div class="col-xs-6 col-sm-6 col-md-6">' . "\n";
	echo '            <div class="form-group">' . "\n";
	echo '                <label for="typeName ' . $cnt . '">Type Name (Name in files)</label>' . "\n";
	echo '                <input type="text" data-parant="typeNameTop' . $cnt . '" name="typeName' . $cnt . '" id="typeName' . $cnt . '" class="form-control input-sm" value="' . $variant['typeName'] . '" required>' . "\n";
	echo '            </div>' . "\n";
	echo '        </div>' . "\n";
	echo '    </div>' . "\n";
	echo '    <div class="row">' . "\n";
	echo '        <div class="col-xs-6 col-sm-6 col-md-6">' . "\n";
	echo '            <div class="form-group">' . "\n";
	echo '                <label for="commands' . $cnt . '">Commands</label>' . "\n";
	echo '                <textarea class="form-control" data-parant="commandsTop' . $cnt . '" name="commands' . $cnt . '" id="commands' . $cnt . '" rows="5">' . $commandStr . '</textarea>' . "\n";
	echo '            </div>' . "\n";
	echo '        </div>' . "\n";
	echo '        <div class="col-xs-6 col-sm-6 col-md-6">' . "\n";
	echo '            <div class="form-group">' . "\n";
	echo '                <label for="maps' . $cnt . '">Maps (Filename=Displayname)</label>' . "\n";
	echo '                <textarea class="form-control" data-parant="mapsTop' . $cnt . '" name="maps' . $cnt . '" id="maps' . $cnt . '" rows="5">' . $mapsStr . '</textarea>' . "\n";
	echo '            </div>' . "\n";
	echo '        </div>' . "\n";
	echo '    </div>' . "\n";
	echo '<button data-id="' . $cnt . '" type="button" class="btn btn-danger btn-lg btn-block">Delete</button>';
	echo '</div>' . "\n";
	$cnt++;
}
?>
					</div>
						<input type="text" style="display: none" id="variantCount" name="variantCount" class="form-control input-sm readonly" value="<?php echo $cnt - 1 ?>" readonly />
						<button type="button" id="AddVariant" class="btn btn-success btn-lg btn-block">Add Variant</button>
						<div id="tmpDis"></div>
				</div>
			</div>
		</form>
		</main>
	  </div>
    </div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	
	<script src="js/slider.js"></script>
	<script src="js/main.js"></script>
	<script src="js/fileSystem.js"></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
	
	<!-- CTG JS -->
	<?php 
		
	?>
    <script>
      feather.replace();
    </script>
	<script src="js/rcon.js"></script>
	</body>
</html>