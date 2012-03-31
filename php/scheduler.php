<?php
	include('scheduler_group.php');
?>
<div id="container_content" class="container_bodies">

	<?php include("../php/content_header.php"); ?>
	
	<div id="container_content_body">
		<?php 
			$group_name = "";
			$group_name_sub = $_GET['q'];
			if($group_name_sub == '') {
				$group_name = "Like a ";
				$group_name_sub = "BOSS";
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