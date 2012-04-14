<?php
?>
<div class="modal_container">
	<div class="modal">
		<div class="modal_progress">
			<span class="modal_overall_title modal_progress">Contacting Server</span>
			<div class="modal_progress_bar">	
				<div id="modal_progress_ball_1" class="modal_progress_ball"></div>
				<div id="modal_progress_ball_2" class="modal_progress_ball"></div>
				<div id="modal_progress_ball_3" class="modal_progress_ball"></div>
				<div id="modal_progress_ball_4" class="modal_progress_ball"></div>
			</div>
		</div>
		<div class="workshop_url">
			<span class="modal_overall_title modal_url">AwsmSauce!</span>
			<div class="modal_url_info">
				On <span class="modal_url_date"></span> go to this URL to participate in the workshop:
			</div>
			<textarea class="modal_url_url" readonly="readonly"></textarea>
			<div class="modal_url_info_bottom">
				Remember, this is <span class="modal_url_info_bottom_highlight"> your personal</span> link. Don&rsquo;t share it with a prince.
			</div>
		</div>
		<div class="modal_facebook_login">
			<span class="modal_overall_title modal_facebook">Hold On There</span>
			<div class="modal_login_content">
				<span>You'll need to login with Facebook in order to continue</span>
			</div>
			<div class="modal_facebook_button button">Login with Facebook</div>
		</div>
		<form id="modal_form"> 
			<span class="modal_overall_title modal_teach">Create A Workshop</span>
			<span class="modal_overall_title modal_learn">More Information</span>
			<div class="modal_layer_one">
				<span class="modal_title_label">Workshop Title </span>
				<input type="text" class="modal_teach_title_input" name="title" />
				<div class="container_clear"></div>
			</div>
			<div class="modal_layer_one">
				<span class="modal_title_label">Technology </span>
				<input type="text" class="modal_teach_title_input" name="technology" placeholder="seperate with spaces"/>
				<div class="container_clear"></div>
			</div>
			<div class="modal_layer_one">
				<span class="modal_title_label">Description </span>
				<textarea class="modal_description_input_update" name="descrition"></textarea>
				<div class="container_clear"></div>
			</div>
			<div class="modal_layer_one">
				<span class="modal_title_label">Date &amp; Time </span>
				<input type="text" class="modal_teach_title_input" name="date" readonly="readonly" placeholder="click to set"/>
				<div class="container_clear"></div>
			</div>
			
			<!-- Display Instructor -->
			<div class="modal_layer_one intructor_field">
				<span class="modal_title_label">Instructor</span>
				<div class="modal_instructor_update">
					<div class="modal_instructor_update_info">
						<!--<img src="../assets/img/user_50.png" class="modal_instructor_img_update" />-->
						<div class="modal_instructor_img_update"> </div>
						<div class="modal_instructor_name"></div>
					</div>
					<div class="modal_instructor_update_rating">
						<span class="modal_instructor_update_rating_good"></span>
						<div class="modal_instructor_update_img"></div>
						
					</div>
					
					<div class="container_clear"></div>
				</div>
				<div class="container_clear"></div>
			</div>
			<div class="modal_layer_one participants_field">
				<span class="modal_title_label">Participants</span>
				<div class="modal_participants_info_container">
					<span class="modal_participants_info_amount"></span> Confirmed
					<div class="modal_participants_img_container">
						
					</div>
				</div>
				<div class="container_clear"></div>
			</div>
		
			<div class="modal_bottom">
				<button type="submit" class="modal_button_bottom modal_teach button">Create</button>
				<div class="modal_button_bottom modal_learn button">Register</div>
			</div>
		</form>
	</div>
	<div class="modal_backdrop"></div>
	<div class="container_clear"></div>
</div>