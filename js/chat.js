/**
 * @author Ezra Velazquez
 */

var Chat = function() {
	var chat_enable = false;
	var socket;
	var my_name = 'Guest';
	
	function _connectToServer() {
		socket = io.connect('http://localhost:8010');
		socket.on('start', function(data) {
			//console.log(data);
		});
		
		socket.on('message_all', function(data) {
			//console.log("function: message_all");
			//console.log(data);
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
			//console.log(current_time.getHours());
			//console.log(current_time.getMinutes());
			//console.log(my_name);
		
		socket.emit('message', 
					{	text : message,
						name : my_name,
						time_sent : current_hour + ":"+current_minute
					}
		);
	}
	
	return {
		init : function() {
			//console.log("chat should load here");
			chat_enable = true;
			_connectToServer();
		},
		enabled : function() {
			return chat_enable;
		},
		sendMessage : function(data) {
			//console.log("inside Chat");
			_sendMessage(data);
		},
		setName : function(name) {
			// Informal chat, so only display first name
			my_name = name.split(" ")[0];
		},
		getName : function() {
			return my_name;
		}
	}
}();