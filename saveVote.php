<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	};
	
	include("settings.conf.php");
	include("methods.php");
	
	function ischecked($val) {
		if (!empty($val))
			return 1;
		else
			return 0;
	}
	
	function pushMainMap($display, $name) {
		$newArray['displayName'] = $display;
		$newArray['mapName'] = $name;
		$array[] = $newArray;
		return $newArray;
	}
	
	function pushVariantInfo($display, $name, $commands, $maps) {
		$newArray = [];
		$newArray['displayName'] = $display;
		$newArray['typeName'] = $name;
		$newArray['commands'] = explode("\r\n", $commands);
		$mapsArray = explode("\n", $maps);
		$newArray['SpecificMaps'] = [];
		foreach ($mapsArray as &$map){
			$mapArray = [];
			$mapInfo = explode("=", $map);
			if (count($mapInfo) > 1) {
				$mapArray['mapName'] = $mapInfo[0];
				$mapArray['displayName'] = $mapInfo[1];
				$newArray['SpecificMaps'][] =  $mapArray;
			}
		}
		return $newArray;
	}
	
	$jsonArray = [];
	
	
	$jsonArray['Maps'] = [];
	if (ischecked($_POST['Bunkerworld']))
		$jsonArray['Maps'][] = pushMainMap("Standoff", "Bunkerworld");
	if (ischecked($_POST['Shrine']))
		$jsonArray['Maps'][] = pushMainMap("Sandtrap", "Shrine");
	if (ischecked($_POST['s3d_turf']))
		$jsonArray['Maps'][] = pushMainMap("Icebox", "s3d_turf");
	if (ischecked($_POST['s3d_reactor']))
		$jsonArray['Maps'][] = pushMainMap("Reactor", "s3d_reactor");
	if (ischecked($_POST['Chill']))
		$jsonArray['Maps'][] = pushMainMap("Narrows", "Chill");
	if (ischecked($_POST['Deadlock']))
		$jsonArray['Maps'][] = pushMainMap("High Ground", "Deadlock");
	if (ischecked($_POST['Zanzibar']))
		$jsonArray['Maps'][] = pushMainMap("Last Resort", "Zanzibar");
	if (ischecked($_POST['riverworld']))
		$jsonArray['Maps'][] = pushMainMap("Valhalla", "riverworld");
	if (ischecked($_POST['Cyberdyne']))
		$jsonArray['Maps'][] = pushMainMap("The Pit", "Cyberdyne");
	if (ischecked($_POST['guardian']))
		$jsonArray['Maps'][] = pushMainMap("Guardian", "guardian");
	if (ischecked($_POST['s3d_avalanche']))
		$jsonArray['Maps'][] = pushMainMap("Diamondback", "s3d_avalanche");
	
	$jsonArray['Types'] = [];
	
	for ($index = 0; $index <= $_POST['variantCount']; $index++) {
		if (isset($_POST["displayName" . $index])) {
			$jsonArray['Types'][] = pushVariantInfo($_POST['displayName' . $index], $_POST['typeName' . $index], $_POST['commands' . $index], $_POST['maps' . $index]);
		}
	}
	file_put_contents($VOTING_location, json_encode($jsonArray, JSON_PRETTY_PRINT)) or die("Unable to save Config");
	echo array2string("Voting JSON Saved.");
?>