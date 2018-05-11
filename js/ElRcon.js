class ElRcon {
	
	constructor(host, port, pass) {
		this.host = host;
		this.port = port;
		this.pass = pass;
		this.lastMessage = "";
		this.lastSent = "";
		
		this.connected = false;
		this.hadshakeSuccess = false;
		this.isSending = false;
		this.addToLog = true;
		this.socket = "";
	}
	
	SocketOpened() {
		this.connected = true;
		this.SendHandshake();
	}
	
	SocketClosed() {
		this.connected = false;
		this.isSending = false;
	}
	
	SocketError() {
		this.connected = false;
		this.isSending = false;
	}
	
	MessageRecieved(event) {
		if (!this.hadshakeSuccess) {
			if (event.data == "accept") {
				this.hadshakeSuccess = true;
				this.connected = true;
			}
			else {
				this.hadshakeSuccess = false;
				this.connected = false;
			}
		}
		if (this.addToLog) {
			this.lastMessage = event.data;
		}
		this.isSending = false;
	}
	
	SendHandshake(callback) {
		this.SendMessage(this.pass, callback);
	}
	
	waitForMessages(callback, rtnMsg){
		var par = this;
		setTimeout(function () {
			if (!par.isSending) {
				if(callback != null){
					callback(par.lastMessage);
				}
				return;

			} else {
				par.waitForMessages(callback, par.lastMessage);
			}

		}, 5); // wait 5 milisecond for the connection...
	}
	
	waitForPrevMessages(callback, rtnMsg){
		var par = this;
		setTimeout(function () {
			if (!par.isSending) {
				if(callback != null){
					callback(rtnMsg);
				}
				return;

			} else {
				par.waitForPrevMessages(callback, rtnMsg);
			}

		}, 5); // wait 5 milisecond for the connection...
	}
	
	waitForConnection(callback){
		var par = this;
		setTimeout(function () {
			if (par.connected) {
				if(callback != null){
					callback();
				}
				return;

			} else {
				par.waitForConnection(callback);
			}

		}, 5); // wait 5 milisecond for the connection...
	}
	
	Connect(callback, messageCall) {
		
		var par = this;
		this.socket = new  WebSocket("ws://" + this.host + ":" + this.port, "dew-rcon");
		this.socket.onopen = function(){ par.SocketOpened(); };
		this.socket.onclose = function(){ par.SocketClosed(); };
		this.socket.onerror = function(){ par.SocketError(); };
		this.socket.onmessage = function(event){ par.MessageRecieved(event); if (messageCall != null)messageCall(event.data); };
		
		this.SendHandshake(callback);
	}
	
	Close() {
		if (this.connected) {
			this.socket.close();
			this.connected = false;
			this.hadshakeSuccess = false;
		}
	}
	
	SendMessage(message, callback, addToLog = true) {
		this.addToLog = addToLog;
		if (this.connected) {
			var par = this;
			this.waitForPrevMessages(function (message) {
				par.isSending = true;
				par.socket.send(message);
				//while(this.isSending) { };
				par.waitForMessages(callback, par.lastMessage);
				return par.lastMessage;
			}, message);
		}
		else if (!this.hadshakeSuccess) {
			var par = this;
			this.waitForConnection(function() {
				par.isSending = true;
				par.socket.send(par.pass);
				//while(this.isSending) { };
				par.waitForMessages(callback,par.lastMessage);
				if (par.hadshakeSuccess) par.SendMessage(message);
			});
		}
		else {
			return "not connected";
		}
	}
}