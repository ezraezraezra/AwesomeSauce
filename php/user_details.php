<?php
    include_once('server.php');
/**
 * @author Ezra Velazquez
 * 
 * Project:     AwesomeSauce
 * Description: Live telepresence micro-workshop platform          
 * Website:     http://awsmsauce.org
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        May 2011
 * 
 */	
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
		
		$workshop_ids = $server->getWorkshop('personal', 'both', $u_id);
		$w_ids = '<ul class="user_details_wids">';
		for($x = 0; $x < count($workshop_ids); $x++) {
			$w_ids.='<li>'.$workshop_ids[$x]['id'].'</li>';
		}
		$w_ids.='</ul>';
		
		$result = '<div class="hidden_info user_details" sid="'.$internal_ids['student_id'].'" iid="'.$internal_ids['instructor_id'].'">'.$w_ids.'</div>';
		
		//$return = displayPage($results);
		$server->closeApp();
		
//		return $return;
		print $result;
	}
?>