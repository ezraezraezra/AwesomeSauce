<?php
    include_once('server.php');
	
	function implantUserDetails($u_id) {
		$server = new Server();
		$server->startApp();
		//$results = $server->getWorkshop($view, $query, $instructor_id);
		
		/*
		 * Write functions in SERVER that returns my student_id, instructor_id, & all workshops I'm involved in
		 */
		$internal_ids = $server->getUserDetails($u_id);
		
		foreach( $internal_ids as $key => $value){
			if($value == "") {
				$internal_ids[$key] = 0;
			}
		}
		
		$result = '<div class="hidden_info user_details" sid="'.$internal_ids['student_id'].'" iid="'.$internal_ids['instructor_id'].'"></div>';
		
		//$return = displayPage($results);
		$server->closeApp();
		
//		return $return;
		print $result;
	}
?>