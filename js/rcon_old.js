$('#consoleContainer').height($('#rconMain').height() - 50).css({"top": "45px", "position": "relative"});
$('#messageLog').height($('#consoleContainer').height() - $('#commandContainer').height());
var connected = false;
var lastResponse = "";
var messages = [];
var msgCount = 0;
var socket;

var commands = [];
var commandsCount = 0;
//alert("<?php echo gethostbyname($_SERVER['HTTP_HOST']) ?>");

function getRconPass() {
	var rtrn = "";
	$.ajax({
		type : "POST",
		url : "getPass.php",
		data : "",
		async: false,
		beforeSend : function() {
			  //$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
		},
		success : function(response) {
			if (response == 0)
				rtrn = 0;
			else {
				rtrn = response.split("::");
			}
	//alert(rtrn);
		}
	});
	//alert(rtrn);
	return rtrn;
}

function listPlayers() {
	connectRCON("Server.ListPlayers", function(msg) {
		$("#playerListDiv").html('<div class="list-group-item disabled list-group-info"><div class="variantContent">Display Name</div><div class="variantContent">Type Name</div><div class="variantContent">Start Commands</div><div class="variantContent">Specific Maps</div></div>');
		var mess = lastResponse;
		var players = mess.split("\n");
		var testStr = "[0] \"Lazy Algorithm\" (uid: 27bb07c8622bfc20, ip: 68.39.255.32)";
		for (i = 0; i < players.length; i++) {
			var usernamePattern = /\"([^)]+)\"/;
			var uinfoPattern = /\(([^)]+)\)/;
			var unameExe = usernamePattern.exec(players[i]);
			if (unameExe != null) {
			var username = unameExe[unameExe.length - 1];
			var infoExe = uinfoPattern.exec(players[i]);
			var info = infoExe[infoExe.length - 1];
			info = info.replace(" ", "");
			var infoArray = info.split(',');
			var uid = infoArray[0].split(":")[1];
			var ip = infoArray[1].split(":")[1];
			
			var newHTML = ''+
'					<div id="playerItem" class="list-group-item">' +
'						<div class="playerContent">' + username + '</div>'+
'						<div class="playerContent">' + uid + '</div>'+
'						<div class="playerContent">' + ip + '</div>'+
'						<div class="playerContent">'+
'							<div class="btn-group btn-group-sm" role="group">'+
'							  <button type="button" onclick="kickUser(\'' + uid + '\');" class="btn btn-warning">Kick</button>'+
'							  <button type="button" onclick="tmpBanUser(\'' + uid + '\');" class="btn btn-danger">Temp Ban</button>'+
'							  <button type="button" onclick="banUser(\'' + uid + '\');" class="btn btn-dark">Ban</button>'+
'							</div>'+
'						</div>'+
'					</div>';
			$("#playerListDiv").append(newHTML);
			}
		}
		setTimeout(listPlayers(), 5000);
	}, false);
}

function kickUser(uid) {
	connectRCON("Server.KickUid " + uid, function(msg) {
		listPlayers();
	});
}

function tmpBanUser(uid) {
	connectRCON("Server.KickTempBanUid " + uid, function(msg) {
		listPlayers();
	});
}

function banUser(uid) {
	connectRCON("Server.KickBanUid " + uid, function(msg) {
		listPlayers();
	});
}

function connectRCON(command, callback, log = true) {
	var info = getRconPass();
	var pword = info[2];
	var host = info[0];
	var rconPort = info[1];
	if (command == pword) {
		if(log) AddToLog("Checking RCON connection...");
		$("#commandSubmit").prop('disabled', true);
		$("#rconCommand").prop('disabled', true);
	}
	socket = new  WebSocket("ws://" + host + ":" + rconPort, "dew-rcon");
	socket.onopen = function (event) {
		if (command == pword) {
			socket.send(pword);
		}
		else {
			socket.send(pword); 
			if(log) AddToLog("Admin: Sending command \"" + command + "\"");
			socket.send(command);
		}
		//socket.close();
	};
	socket.onclose = function() {
		connected = false;
	};
	socket.onerror = function (event) {
		if(log) AddToLog("Unable to connect to RCON server");
		$("#commandSubmit").prop('disabled', true);
		$("#rconCommand").prop('disabled', true);
		return;
	};
	socket.onmessage = function (event) {
		if (command == pword) {
			if (event.data == "accept")
			{
				if(log) AddToLog("Connection Accepted");;
				$("#commandSubmit").prop('disabled', false);
				$("#rconCommand").prop('disabled', false);
				socket.close();
			}
			else {
				if(log) AddToLog("Connection Refused");
				$("#commandSubmit").prop('disabled', true);
				$("#rconCommand").prop('disabled', true);
				socket.close();
				return;
			}
			callback(lastResponse);
		}
		else {
			msgCount = messages.push(event.data);
			lastResponse = event.data;
			if (msgCount == 2)
			{
				if(log) AddToLog("Server: " + event.data);
				socket.close();
				messages = [];
				msgCount = 0;
				callback(lastResponse);
			}
			//$("#rconmsg").html(lastResponse);
		}
	};
}

function waitForMessages(socket, callback){
	setTimeout(function () {
		if (msgCount == 2) {
			if(callback != null){
				callback();
			}
			return;

		} else {
			waitForMessages(socket, callback);
		}

	}, 5); // wait 5 milisecond for the connection...
}



function AddToLog(message) {
	var newAdd = message;
	if ($("#messageLog").val() != "")
		var newAdd = "\r\n" + message.toString().replace(/\n|\r/g, "");
	$("#messageLog").val($("#messageLog").val() + newAdd);
	console.log(message);
	$('#messageLog').scrollTop($('#messageLog')[0].scrollHeight);
}

$(document).ready(function() {
	var info = getRconPass();
	connectRCON(info[2], function(msg) {
		
	});
});

$("#commandSubmit").click(function(e) {
	connectRCON($("#rconCommand").val(), function(msg) {
		commandsCount = commands.push($("#rconCommand").val()) - 1;
		selectedComm = null;
		$("#rconCommand").val("");
	});
});

var selectedComm = null;
var upPressed = false;
var downPressed = false;
function selectCommand(num) {
	if (num > 0) {
		if (selectedComm == null) 
			selectedComm = commandsCount;
		else if ((selectedComm - num) >= 0) {
			selectedComm -= num;
		}
	}
	else {
		if (selectedComm == null) 
			selectedComm = 0;
		else if ((selectedComm - num) <= commandsCount) {
			selectedComm -= num;
		}
	}
	$("#rconCommand").val(commands[selectedComm]);
}
$(document).keydown(function(e){
	if (e.keyCode == 38 && !upPressed) { 
	   upPressed = true;
	   selectCommand(1);
	   return false;
	}
	if (e.keyCode == 40 && !downPressed) { 
	   downPressed = true;
	   selectCommand(-1);
	   return false;
	}
});
$(document).keyup(function(e){
	if (e.keyCode == 38 && upPressed) { 
	   upPressed = false;
	   return false;
	}
	if (e.keyCode == 40 && downPressed) { 
	   downPressed = false;
	   return false;
	}
});
$("#rconCommand").keypress(function(e) {
	if(e.which == 13) {
		if ($("#rconCommand").val() != "")
			$( "#commandSubmit" ).click();
	}
});
//while(!connected){}

//alert(SendCommand("Server.Name"));
//exampleSocket.close();