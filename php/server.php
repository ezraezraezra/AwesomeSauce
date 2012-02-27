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
	}
	
	$operation = $_GET['o'];
	$results = "";
	
	$server = new Server();
	$server->startApp();
	// $results = json_encode($server->function to call);
	switch($operation) {
		case "add":
			$date = mysql_real_escape_string($_GET['d']);
			$title = mysql_real_escape_string($_GET['t']);
			$desc = mysql_real_escape_string($_GET['de']);
			$inst_fb_id = mysql_real_escape_string($_GET['i']);
			$inst_name = mysql_real_escape_string($_GET['n']);
			
			$results = json_encode($server->addWorkshop($date, $title, $desc, $inst_fb_id, $inst_name));
			break;
		default:
			// This should never be reached
			$results = json_encode(array('status'=>'400', 'message'=>'bad operation given'));
			break;
	}
	
	$server->closeApp();
	echo $results;
	
?>