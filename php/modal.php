<?php
?>
<div class="modal_container">
	<div class="modal">
		<span class="modal_overall_title">Create A Workshop</span>
		<div class="modal_layer_one">
			<span class="modal_title_label">Workshop Title </span>
			<input type="text" class="modal_teach_title_input modal_teach" />
			<div class="container_clear"></div>
		</div>
		<div class="modal_layer_one">
			<span class="modal_title_label">Technology </span>
			<input type="text" class="modal_teach_title_input modal_teach" placeholder="seperate with commas"/>
			<div class="container_clear"></div>
		</div>
		<div class="modal_layer_one">
			<span class="modal_title_label">Description </span>
			<textarea class="modal_description_input_update"></textarea>
			<div class="container_clear"></div>
		</div>
		<div class="modal_layer_one">
			<span class="modal_title_label">Date &amp; Time </span>
			<input type="text" class="modal_teach_title_input modal_teach" readonly="readonly" placeholder="click to set"/>
			<div class="container_clear"></div>
		</div>
		
		<!-- Display Instructor -->
		<div class="modal_layer_one">
			<span class="modal_title_label">Instructor</span>
			<div class="modal_instructor_update">
				<div class="modal_instructor_update_info">
					<img src="../assets/img/user_50.png" class="modal_instructor_img_update" />
					<div class="modal_instructor_name">Ezra Velazquez</div>
				</div>
				<div class="modal_instructor_update_rating">
					<img class="modal_instructor_update_img" src="../assets/img/rating_good.png">
					<div class="modal_instructor_update_rating_good">150</div>
					<img class="modal_instructor_update_img" src="../assets/img/rating_bad.png">
					<div class="modal_instructor_update_rating_bad">2</div>
				</div>
				
				<div class="container_clear"></div>
			</div>
			<div class="container_clear"></div>
		</div>
	
		<div class="modal_bottom">
			<div class="modal_button_bottom modal_teach button">Create</div>
			<div class="modal_button_bottom modal_learn button">Register</div>
		</div>
	</div>
	<div class="modal_backdrop"></div>
	<div class="container_clear"></div>
</div>