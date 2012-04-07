<?php
?>
<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/tb.js"></script>
<script type="text/javascript" src="../js/lib/io/dist/socket.io.js"></script>
<script type="text/javascript" src="../js/chat.js"></script>
<script type="text/javascript" src="../js/lib/etherpad.js"></script>
<script type="text/javascript" src="../js/text_editor.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		OpenTok.init();
		Chat.init();
		TextEditor.init();
	});
	
</script>

<div id="container_content" class="container_bodies">
	<div class="container_content_header container_classroom_header">
		<div class="container_content_header_logo"> </div>
		<span class="container_classroom_header_title">WORKSHOP TITLE GOES HERE</span>
		<div class="container_clear"></div>
</div>
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
					<div class="container_clear"></div>
				</div>
			</div>
 			<div class="classroom_right_container classroom_inner_container">
 				<div class="blackboard_container">
 					<span class="classroom_labels">Whiteboard</span>
 					<div class="blackboard_module" id="blackboard_module"></div>
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