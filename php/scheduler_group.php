<?php
	include('result.php');
	
	function displaySchedulerGroup($group_name, $group_name_sub, $view, $query) {
		$print = '';
		$print.='<div class="container_content_body_group">';
		$print.='<div class="container_content_body_group_name">';
		$print.=$group_name.'<span class="container_content_body_group_search_value">'.$group_name_sub.'</span>';
		$print.='</div>';
	
		$print.='<div class="container_content_body_group_results">';
		$print.=displayResult($view, $query);
		$print.='</div>';
		$print.='</div>';
		
		printf($print);
	} 

?>