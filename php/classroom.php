<?php
?>
<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/tb.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		OpenTok.init();
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
 					<div class="textchat_module"></div>
 				</div>
 			</div>
 			<div class="container_clear"></div>
		</div>
</div>