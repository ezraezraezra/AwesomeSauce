<?php
?>
<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/tb.js"></script>
<script type="text/javascript" src="../js/lib/io/dist/socket.io.js"></script>
<script type="text/javascript">
	var Chat = function() {
		var chat_enable = false;
		var socket;
		var my_name = 'Guest';
		
		function _connectToServer() {
			socket = io.connect('http://localhost:8010');
			socket.on('start', function(data) {
				console.log(data);
			});
			
			socket.on('message_all', function(data) {
				console.log("function: message_all");
				console.log(data);
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
				console.log(current_time.getHours());
				console.log(current_time.getMinutes());
				console.log(my_name);
			
			socket.emit('message', 
						{	text : message,
							name : my_name,
							time_sent : current_hour + ":"+current_minute
						}
			);
		}
		
		return {
			init : function() {
				console.log("chat should load here");
				chat_enable = true;
				_connectToServer();
			},
			enabled : function() {
				return chat_enable;
			},
			sendMessage : function(data) {
				console.log("inside Chat");
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
</script>
<script type="text/javascript">
	$(document).ready(function() {
		OpenTok.init();
		Chat.init();
		//OpenTok.setData();
	});
	
</script>

<div id="container_content" class="container_bodies">
<div class="classroom_container">
			<div class="classroom_left_container classroom_inner_container">
				<div class="instructor_container">
					<span class="instructor_name classroom_labels">Instructor</span>
					<div class="video_feed_instructor" id="video_feed_instructor"></div>
					<div class="instructor_button_container">
						<div class="instructor_rate_button instructor_good_img button">75%</div>
						<div class="instructor_rate_button instructor_bad_img button">25%</div>
					</div>
				</div>
				<div class="students_container">
					<!--
					<div class="student_container">
						<span class="student_name classroom_labels">Paul McCartney</span>
						<div class="video_feed_student"></div>
					</div>
					<div class="student_container">
						<span class="student_name classroom_labels">Ringo Starr</span>
						<div class="video_feed_student"></div>
					</div>
					<div class="student_container">
						<span class="student_name classroom_labels">John Lennon</span>
						<div class="video_feed_student"></div>
					</div>
					<div class="student_container">
						<span class="student_name classroom_labels">George Harrison</span>
						<div class="video_feed_student"></div>
					</div>
					-->
					<div class="container_clear"></div>
				</div>
			</div>
 			<div class="classroom_right_container classroom_inner_container">
 				<div class="blackboard_container">
 					<span class="classroom_labels">Whiteboard</span>
 					<div class="blackboard_module"></div>
 				</div>
 				<div class="textchat_container">
 					<span class="classroom_labels">Informal Class Chat</span>
 					<div class="textchat_module">
 						<textarea class="textchat_output" readonly="readonly"></textarea>
						<form id="chat_form">
							<input type="text" class="textchat_input" placeholder="type message here" name="textchat_input">
							<input type="submit" id="chat_submit" value="">
						</form>
 					</div>
 				</div>
 			</div>
 			<div class="container_clear"></div>
		</div>
</div>