var info = getRconPass();
var pword = info[2];
var host = info[0];
var rconPort = info[1];
var commands = [];
var commandsCount = 0;
var selectedComm = null;
var upPressed = false;
var downPressed = false;
var previousPlayers = "";

var socket = new ElRcon(host, rconPort, pword);

$(document).ready(function() {
	AddToLog("Attepting to connect");
	socket.Connect(function(mess) { 
		AddToLog("Connection Accepted");
		//listPlayers();
		setInterval(function(){ listPlayers(); }, 3000);
	},
	function (msg) {
		//AddToLog("Server: " + msg);
	});
});

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

function AddToLog(message) {
	var newAdd = message;
	if ($("#messageLog").val() != "")
		var newAdd = "\r\n" + message.toString().replace(/\n|\r/g, "");
	$("#messageLog").val($("#messageLog").val() + newAdd);
	console.log(message);
	$('#messageLog').scrollTop($('#messageLog')[0].scrollHeight);
}

$("#commandSubmit").click(function(e) {
	AddToLog("Sent:  " + $("#rconCommand").val());
	socket.SendMessage($("#rconCommand").val(), function(mess) {
		AddToLog("Reply: " + mess);
		commandsCount = commands.push($("#rconCommand").val()) - 1;
		selectedComm = null;
		$("#rconCommand").val("");
		/*connectRCON($("#rconCommand").val(), function(msg) {
			commandsCount = commands.push($("#rconCommand").val()) - 1;
			selectedComm = null;
			$("#rconCommand").val("");
		});*/
	});
});

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

$("#rconCommand").keypress(function(e) {
	if(e.which == 13) {
		if ($("#rconCommand").val() != "")
			$( "#commandSubmit" ).click();
	}
});

$("#rconCommand").keydown(function(e){
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
$("#rconCommand").keyup(function(e){
	if (e.keyCode == 38 && upPressed) { 
	   upPressed = false;
	   return false;
	}
	if (e.keyCode == 40 && downPressed) { 
	   downPressed = false;
	   return false;
	}
});

function kickUser(uid) {
	socket.SendMessage("Server.KickUid " + uid, function(msg) {
		listPlayers();
	});
}

function tmpBanUser(uid) {
	socket.SendMessage("Server.KickTempBanUid " + uid, function(msg) {
		listPlayers();
	});
}

function banUser(uid) {
	socket.SendMessage("Server.KickBanUid " + uid, function(msg) {
		listPlayers();
	});
}

function listPlayers() {
	socket.SendMessage("Server.ListPlayers", function(mess) { 
		
		//var mess = socket.SendMessage("Server.ListPlayers");
		var players = mess.split("\n");
		if (previousPlayers != mess) {
			$("#playerListDiv").html('<div class="list-group-item disabled list-group-info"><div class="variantContent">Player Name</div><div class="variantContent">User ID</div><div class="variantContent">IP Adress</div><div class="variantContent">Controls</div></div>');
			previousPlayers = mess
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
		}
	});
}