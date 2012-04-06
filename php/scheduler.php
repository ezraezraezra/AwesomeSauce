<?php
	include('scheduler_group.php');
	include('user_details.php');
	
	$quotes = array(
				array('Like a ', 'BOSS'),
				array('Haters gonna ','HATE')
			);		
			
	$rand = rand(0, count($quotes) - 1);
?>
<div id="container_content" class="container_bodies">

	<?php include("../php/content_header.php"); ?>
	
	<div id="container_content_body">
		<?php 
			if($display == 'me') {
				
				$instructor_id = $facebook_userId;
				
				$group_name = 'Workshops I\'m ';
				
				
				$group_name_sub = 'Attending';
				$view = 'personal';
				$query = 'attend';
				displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
				
				$group_name_sub = 'Leading';
				$view = 'personal';
				$query = 'teach';
				displaySchedulerGroup($group_name, $group_name_sub, $view, $query, $instructor_id);
				
			}
			else {
		
		
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
			
			}
			
			// Hide user info
			$u_id = $facebook_userId;
			//$u_id = 1088730508;
			if($u_id != 0) {
				implantUserDetails($u_id);
			}
		?>
	</div>
</div>