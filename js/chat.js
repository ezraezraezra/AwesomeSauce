/**
 * @author Ezra Velazquez
 */

var Chat = function() {
	var chat_enable = false;
	var socket;
	var my_name = 'Guest';
	var wid = 0;
	
	function _connectToServer() {
		socket = io.connect('http://localhost:8010');
		socket.on('start', function(data) {
			// Connected
		});
		
		socket.on('message_'+wid, function(data) {
			var text_to_display = data.message.name + " @ " + data.message.time_sent + " " + data.message.text;
			$(".textchat_output").append(text_to_display + "\n");
			$(".textchat_output").scrollTop($(".textchat_output").height());
		});
	}
	
	function _sendMessage(message) {
		var current_time = new Date();
		var current_hour = current_time.getHours();
		var current_minute = current_time.getMinutes();
		if(current_minute < 10) {
			current_minute = "0" + current_minute;
		}
		
		socket.emit('message', 
					{	wid  : 'message_'+wid,
						text : message,
						name : my_name,
						time_sent : current_hour + ":"+current_minute
					}
		);
	}
	
	function _setUniqueChatKey() {
		var values = new Array();
		var search = window.location.search.substring(1).split("&");
		for(var i = 0; i < search.length; i++) {
			pairs = search[i].split("=");
			values[pairs[0]] = pairs[1];
		}
		return values['wid'];
	}
	
	return {
		init : function() {
			wid = _setUniqueChatKey();
			chat_enable = true;
			_connectToServer();
		},
		enabled : function() {
			return chat_enable;
		},
		sendMessage : function(data) {
			_sendMessage(data);
		},
		setName : function(name) {
			my_name = name.split(" ")[0];
		},
		getName : function() {
			return my_name;
		}
	}
}();