<?php
	include('scheduler_group.php');
	
	$quotes = array(
				array('Like a ', 'BOSS'),
				array('Gym, tan, ', 'LANDRY'),
				array('Don\'t tase me ','BRO'),
				array('Don\'t break the ','BUILD')
			);		
			
	$rand = rand(0, count($quotes) - 1);
?>
<div id="container_content" class="container_bodies">

	<?php include("../php/content_header.php"); ?>
	
	<div id="container_content_body">
		<?php 
			$group_name = "";
			$group_name_sub = $_GET['q'];
			if($group_name_sub == '') {
				$group_name = $quotes[$rand][0];
				$group_name_sub = $quotes[$rand][1];
			}
			else {
				$group_name = 'Search results for: ';
			}
			
			$view = 'learn';
			$query = $_GET['q'];
			$instructor_id = '0';
			
			displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
		?>
	</div>
</div>