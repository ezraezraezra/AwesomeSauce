<?php

// $group_name = 'Search results for: ';
// $group_name_sub = 'Security JS';

?>
<div class="container_content_body_group">
	<div class="container_content_body_group_name">
		<?php echo $group_name; ?><span class="container_content_body_group_search_value"><?php echo $group_name_sub ?></span>
	</div>
	
	
	<div class="container_content_body_group_results">
		<?php include('result.php'); ?>
	</div>
</div>