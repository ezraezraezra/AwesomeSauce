<?php
	$day_word = 'Tuesday';
	$month = 'Feb';
	$day_number = '14';
	$day_abr = 'th';
	$year = '2012';
	
	$hour = '10';
	$minute = '48';
	$type = 'AM';
	$zone = 'PST';
	
	$user_img = '../assets/img/user_50.png';
	$user_first = 'Ezra';
	$user_last = 'Velazquez';
	
	$title = 'Code Security - how to protect against malevolent programmers';
	
	$tags[0] = 'security';
	$tags[1] = 'PHP';
	$tags[2] = 'Web';
	$tags[3] = 'JS';
	$tag_display = '';
	foreach($tags as $key => $value) {
		if($key == 0) {
			$class= "class='first_list'";
		}
		else {
			$class = "";
		}
		
		$tag_display.="<li ".$class.">".$value."</li>";
	}
?>
<div class="container_content_body_group_result">
	<div class="container_content_body_group_result_date result_seperator">
		<span class="container_content_body_group_result_date_day"><?php echo $day_word.", ".$month." ".$day_number.$day_abr.", ".$year; ?></span>
		<span class="container_content_body_group_result_date_time"><?php echo $hour.":".$minute." ".$type. " (".$zone.")"; ?></span>
	</div>
	<div class="container_content_body_group_result_user result_seperator">
		<img class="container_content_body_group_result_user_img" src="<?php echo $user_img; ?>"/>
		<span class="container_content_body_group_result_user_name"><?php echo $user_first." ".$user_last; ?></span>
	</div>
	<div class="container_content_body_group_result_info result_seperator">
		<span class="container_content_body_group_result_info_title"><?php echo $title; ?></span>
		<ul>
			<?php echo $tag_display; ?>
		</ul>
	</div>
	<div class="container_content_body_group_result_more button">More Info</div>
	<div class="container_clear"></div>
</div>