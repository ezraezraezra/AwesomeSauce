<?php
	//include('server.php');
	include('server.php');
	
	function displayResult($view, $query, $instructor_id) {
		$server = new Server();
		$server->startApp();
		$results = $server->getWorkshop($view, $query, $instructor_id);
		
		$return = displayPage($results);
		$server->closeApp();
		
		return $return;
	}	
	
	function dateFormatter($mysql_date) {
		// Get Date
		$date_format = date('l, M jS, Y', strtotime($mysql_date));
		return $date_format;
	}

	function timeFormatter($mysql_date) {
		// Get Time
		$time_format = date('g:i A', strtotime($mysql_date));
		return $time_format;
	}
	
	function tagFormatter($mysql_tags) {
		$tags = explode(" ", $mysql_tags);
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
		return $tag_display;
	}
	
	function getImage($id) {
		//$user_img = '../assets/img/user_50.png';
		return "https://graph.facebook.com/$id/picture";	
		
	}
	
	function displayPage($results) {
		
		$print = '';
		for($i = 0; $i < count($results); $i++) {
			$print.='<div class="container_content_body_group_result" wid="'.$results[$i]['id'].'">';
			$print.='<div class="container_content_body_group_result_date result_seperator">';
			$print.='<span class="container_content_body_group_result_date_day">'.dateFormatter($results[$i]['date']).'</span>';
			$print.='<span class="container_content_body_group_result_date_time">'.timeFormatter($results[$i]['date']). " (PST)".'</span>';
			$print.='</div>';
			$print.='<div class="container_content_body_group_result_user result_seperator">';
			$print.='<img class="container_content_body_group_result_user_img" src="'.getImage($results[$i]['instructor']['fb_id']).'"/>';
			$print.='<span class="container_content_body_group_result_user_name" fid="'.$results[$i]['instructor']['fb_id'].'" rg="'.$results[$i]['instructor']['rating_good'].'" rb="'.$results[$i]['instructor']['rating_bad'].'">'.$results[$i]['instructor']['name'].'</span>';
			$print.='</div>';
			$print.='<div class="container_content_body_group_result_info result_seperator">';
			$print.='<span class="container_content_body_group_result_info_title">'.$results[$i]['title'].'</span>';
			$print.='<ul>';
			$print.=tagFormatter($results[$i]['tags']);
			$print.='</ul>';
			$print.='</div>';
			$print.='<div class="container_content_body_group_result_more button">More Info</div>';
			$print.='<div class="container_clear">';
			$print.='<span class="hidden_info workshop_description">'.$results[$i]['description'].'</span>';
			$print.='</div>';
			$print.='</div>';
		}
		
		return $print;
	}
	
?>