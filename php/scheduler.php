<?php
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
				$group_name_sub = 'Security JS';
				include('scheduler_group.php');
			}
			else {
				$group_name = 'My Upcoming Classes';
				$group_name_sub = '';
				include('scheduler_group.php');
				
				$group_name = 'My Previous Classes';
				$group_name_sub = '';
				include('scheduler_group.php');
			}
		?>
	</div>
</div>