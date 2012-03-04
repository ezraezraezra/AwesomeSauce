<?php
    header('Content-type: application/json; charset=utf-8');
	require 'info.php';
	
	class Server {
		var $connection;
		var $db_selected;
		var $client;
		var $info_object;
		
		function Server() {
			$this->info_object = new info();
		}
		
		function startApp() {
			$this->connection = mysql_connect($this->info_object->hostname, $this->info_object->user, $this->info_object->pwd);
			if(!$this->connection) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
	
			$this->db_selected = mysql_select_db($this->info_object->database, $this->connection);
			if(!$this->db_selected) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
		}
		
		function closeApp() {
			mysql_close($this->connection);
		}
	
		function submit_info($data, $conn, $return) {
			$result = mysql_query($data,$conn);
			if(!$result) {
				die("Error ".mysql_errno()." : ".mysql_error());
			}
			else if($return == true) {
				return $result;
			}
		}
		
		function checkInstructorStatus($fb_id,$name) {
			$counter = 0;
			$instructor_id = 0;
				
			$request = "SELECT * FROM instructor WHERE fb_id='$fb_id'";
			$request = $this->submit_info($request, $this->connection, true);
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			
			//Check to see if in DB
			foreach ($rows as $row):
				$counter = $counter + 1;
				if($counter >= 1) {
					$instructor_id =  "{$row['id']}";
				}
			endforeach;
			
			//Not in DB
			if($counter == 0) {
				
				$request = "INSERT INTO instructor(name, fb_id) VALUES('$name','$fb_id')";
				$request = $this->submit_info($request, $this->connection, true);
				$instructor_id = mysql_insert_id();
			}
			
			return $instructor_id;
		}
		
		function addWorkshop($date, $title, $desc, $inst_fb_id, $inst_name) {
			// Make instructor table connection	
			$instructor_id = $this->checkInstructorStatus($inst_fb_id, $inst_name);
			
			// Make workshop table connection
			$date_new = date( 'Y-m-d H:i:s', $date );
			$request = "INSERT INTO workshop(date, title, description) VALUES('$date_new', '$title', '$desc')";
			$request = $this->submit_info($request, $this->connection, true);
			$workshop_id = mysql_insert_id();
			
			// Make workshop_X_instructor connection
			$request = "INSERT INTO workshop_X_instructor(instructor_id, workshop_id) VALUES('$instructor_id', '$workshop_id')";
			$request = $this->submit_info($request, $this->connection, true);
			
			$arr = array('status'=>'200', 'message'=>'workshop created');
			return $arr;
		}
		
		function getWorkshops($query,$type) {
			switch($type) {
				// Get all workshops
				case 'all':
					
					break;
				// Get search results
				case 'search':
					break;
			}
		}
		
		function getWorkshop() {
			#SELECT ALL WORKSHOPS W/INSTRUCTOR INFO
			$request = "SELECT w.id AS workshop_id, w.date, w.title, w.description, w.title, w.tags, i.id AS instructor_id, i.name, i.fb_id, i.rating_good, i.rating_bad FROM workshop AS w, instructor AS i, workshop_X_instructor AS wXi WHERE w.id = wXi.workshop_id AND i.id = wXi.instructor_id ORDER BY date DESC, title ASC;";
			$request = $this->submit_info($request, $this->connection, true);
			
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			$workshop = array();
			
			foreach ($rows as $row):
				$workshop[] = array("id"=>"{$row['workshop_id']}", 
									"date"=>"{$row['date']}", 
									"title"=>"{$row['title']}", 
									"description"=>"{$row['description']}",
									"tags"=>"{$row['tags']}",
									"instructor"=> array("id"=>"{$row['instructor_id']}",
														 "name"=>"{$row['name']}",
														 "fb_id"=>"{$row['fb_id']}",
														 "rating_good"=>"{$row['rating_good']}",
														 "rating_bad"=>"{$row['rating_bad']}"
														)
									);
			endforeach;
			
			return $workshop;
		}
	}
	
//	$operation = $_GET['o'];
//	$results = "";

/*	
	$server = new Server();
	$server->startApp();
 */

 	/*
	 * TESTING
	 * get all workshops
	 */

/*
	$response = array("status"=>200,"response"=>$server->getWorkshop());
	$results = json_encode($response);
*/	
	
	// // $results = json_encode($server->function to call);
	// switch($operation) {
		// case "get":
			// $query = mysql_real_escape_string($_GET['q']);
			// $type = mysql_real_escape_string($_GET['t']);
			// $results = json_encode($server->getWorkshops($query,$type));
			// break;
		// // case "add":
			// // $date = mysql_real_escape_string($_GET['d']);
			// // $title = mysql_real_escape_string($_GET['t']);
			// // $desc = mysql_real_escape_string($_GET['de']);
			// // $inst_fb_id = mysql_real_escape_string($_GET['i']);
			// // $inst_name = mysql_real_escape_string($_GET['n']);
// // 			
			// // $results = json_encode($server->addWorkshop($date, $title, $desc, $inst_fb_id, $inst_name));
			// // break;
		// default:
			// // This should never be reached
			// $results = json_encode(array('status'=>'400', 'message'=>'bad operation given'));
			// break;
	// }

/*	
	$server->closeApp();
	echo $results;
*/	
?>