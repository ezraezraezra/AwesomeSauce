<?php
	include('scheduler_group.php');
?>
<div id="container_content" class="container_bodies">
	<div id="container_content_header">
		<?php 
			if($display == 'learn') {
				include('search_bar.php');
			}
			else {
				include('post_bar.php');
			}
		?>
	</div>
	
	<div id="container_content_body">
		<?php 
		
			if($display == 'learn') {
				$group_name = 'Search results for: ';
				//$group_name_sub = 'Security JS';
				$group_name_sub = $_GET['q'];
				
				$view = 'learn';
				$query = $_GET['q'];
				$instructor_id = '0';
				
				displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
			}
			else {
				//$instructor_id = $facebook_userId;
				$instructor_id = '1088730508';
				
				$group_name = 'My Upcoming Classes';
				$group_name_sub = '';
				$view = 'teach';
				$query = 'future';
				displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
				
				
				$group_name = 'My Previous Classes';
				$group_name_sub = '';
				$view = 'teach';
				$query = 'past';
				displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
			}
		?>
	</div>
</div>