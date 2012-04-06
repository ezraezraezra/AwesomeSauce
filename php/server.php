<?php
    //header('Content-type: application/json; charset=utf-8');
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
		
		function getFBid($u_id) {
			if(strcasecmp($u_type, 'user') == 0) {
				$table = 'instructor';
			}
			else {
				$table = 'student';
			}
			
			$request = "SELECT fb_id FROM $table WHERE id='$u_id'";
			$request = $this->submit_info($request, $this->connection, true);
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			foreach ($rows as $row):
				$fb_id =  "{$row['fb_id']}";
			endforeach;
			
			return $fb_id;
		}
		
		function getUserDetails($u_id) {
			$student_id = $this->getUserInternalID($u_id, 'student');
			$instructor_id = $this->getUserInternalID($u_id, 'instructor');
			
			$result = array('student_id'=>$student_id,
							'instructor_id'=>$instructor_id);
			
			return $result;
		}
		
		function getUserInternalID($u_id, $table){
			$request = "SELECT id FROM $table WHERE fb_id='$u_id'";
			$request = $this->submit_info($request, $this->connection, true);
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			foreach ($rows as $row):
				$student_id = "{$row['id']}";
			endforeach;	
				
			return $student_id;
		}
		
		function getClassroom($u_id,$u_type,$w_id) {
			// Get FB_ID	
			$fb_id = $this->getFBid($u_id);
			
			// Get Workshop Name
			$request = "SELECT title, ot_session_id FROM workshop WHERE id='$w_id'";
			$request = $this->submit_info($request, $this->connection, true);
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			foreach ($rows as $row):
				$w_name =  "{$row['title']}";
				$s_id = "{$row['ot_session_id']}";
			endforeach;
			
			$arr = array('status'=>'200', 'w_name'=>$w_name, 'fb_id'=>$fb_id, 's_id'=>$s_id);
			return $arr;
		}
		
		function checkInstructorStatus($fb_id, $name) {
			$request = "SELECT * FROM instructor WHERE fb_id='$fb_id' LIMIT 0,1";
			$request = $this->submit_info($request, $this->connection, true);
			$instructor_id = '0';
			
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			
			//Check to see if in DB
			foreach ($rows as $row):
				$instructor_id =  "{$row['id']}";
			endforeach;
			
			if(!strcasecmp($instructor_id, '0')) {
				$request = "INSERT INTO instructor(name, fb_id) VALUES('$name','$fb_id')";
				$request = $this->submit_info($request, $this->connection, true);
				$instructor_id = mysql_insert_id();
			}
			
			return $instructor_id;
		}
		
		function checkStudentStatus($fb_id) {
			$request = "SELECT * FROM student WHERE fb_id='".$fb_id."'";
			$request = $this->submit_info($request, $this->connection, true);
			$student_id = '0';
			
			while(($rows[] = mysql_fetch_assoc($request)) || array_pop($rows));
			
			//Check to see if in DB
			foreach ($rows as $row):
				$student_id =  "{$row['id']}";
			endforeach;
			
			if(!strcasecmp($student_id, '0')) {
				$request = "INSERT INTO student(fb_id) VALUES('$fb_id')";
				$request = $this->submit_info($request, $this->connection, true);
				$student_id = mysql_insert_id();
			}
				
			return $student_id;
		}
		
		function registerStudent($fb_id, $workshop_id) {
			// Get student's DB ID
			$student_id = $this->checkStudentStatus($fb_id);
			
			//Add student to workshop
			$request = "INSERT INTO workshop_X_student(workshop_id, student_id) VALUES('$workshop_id','$student_id')";
			$request = $this->submit_info($request, $this->connection, true);
			
			$generate_url = $this->generateURL($student_id, 'user', $workshop_id);
			$arr = array('status'=>'200', 'message'=>'student added successfully', 'url_values'=>$generate_url);
			return $arr;
		}
		
		function addWorkshop($title, $tech, $description, $date, $fb_id, $name, $ot_session_id) {
			// Get instructor's DB ID
			$instructor_id = $this->checkInstructorStatus($fb_id, $name);
			
			//Create workshop
			//$date_new = date( 'Y-m-d H:i:s', $date );
			$date_new = date( 'Y-m-d H:i:s', strtotime($date));
			$request = "INSERT INTO workshop(title, description, tags, date, ot_session_id) VALUES('$title', '$description', '$tech', '$date_new', '$ot_session_id')";
			$request = $this->submit_info($request, $this->connection, true);
			$workshop_id = mysql_insert_id();
			
			// Make workshop_X_instructor connection
			$request = "INSERT INTO workshop_X_instructor(instructor_id, workshop_id) VALUES('$instructor_id', '$workshop_id')";
			$request = $this->submit_info($request, $this->connection, true);
			
			$generate_url = $this->generateURL($instructor_id, 'admin', $workshop_id);
			$arr = array('status'=>'200', 'message'=>'workshop created', 'url_values'=>$generate_url);
			return $arr;
			
			
		}
		
		function generateURL($u_id, $type, $w_id) {
			$arr = array('u_id'=>$u_id,'type'=>$type,'w_id'=>$w_id);
			
			return $arr;
		}
		
		
		function getWorkshop($view, $query, $instructor_id) {
			if(!strcasecmp($query, '')) {
				$query = 'all';
			}
			// Learn-View	
			if(!strcasecmp($view, 'learn')) {
				// All Results
				if(!strcasecmp($query, 'all')) {
					#SELECT ALL WORKSHOPS W/INSTRUCTOR INFO
					$request_query = '';
				}
				else {
					//$request_query = '';
					$request_query = " AND (w.description LIKE '%".$query."%' OR w.title LIKE '%".$query."%' OR w.tags LIKE '%".$query."%' OR i.name LIKE '%".$query."%')";
				}
				
				$mysqldate = date( 'Y-m-d H:i:s', time() );
				$request_query = $request_query." AND w.date > '".$mysqldate."'";	
			}
			// Personal-View
			if(!strcasecmp($view, 'personal')) {
				$mysqldate = date( 'Y-m-d H:i:s', time() );
				
				// Attending
				if(!strcasecmp($query, 'attend')) {
					$request_query = " AND s.id = wXs.student_id AND s.fb_id = '".$instructor_id."' AND w.id = wXs.workshop_id AND w.date > '".$mysqldate."'";
				}
				// Teaching
				else {
					$request_query = " AND i.fb_id='".$instructor_id."' AND w.date > '".$mysqldate."'";
				}
			}
/*
			// OLD Teach-View
			else {
				$mysqldate = date( 'Y-m-d H:i:s', time() );
				if(!strcasecmp($query, 'future')) {
					$conditional = '>';
				}
				else {
					$conditional = '<';
				}
				
				$request_query = " AND w.date ".$conditional." '".$mysqldate."' AND i.fb_id='".$instructor_id."'";
			}
*/			
			
			$request = "SELECT DISTINCT w.id AS workshop_id, w.date, w.title, w.description, w.tags, i.id AS instructor_id, i.name, i.fb_id, i.rating_good, i.rating_bad FROM workshop AS w, instructor AS i, workshop_X_instructor AS wXi, workshop_X_student as wXs, student as s WHERE w.id = wXi.workshop_id AND i.id = wXi.instructor_id".$request_query." ORDER BY date ASC, title ASC;";
/*			
			$request = "SELECT DISTINCT w.id AS workshop_id, w.date, w.title, w.description, w.tags, i.id AS instructor_id, i.name, i.fb_id, i.rating_good, i.rating_bad FROM workshop AS w, instructor AS i, workshop_X_instructor AS wXi WHERE w.id = wXi.workshop_id AND i.id = wXi.instructor_id".$request_query." ORDER BY date ASC, title ASC;";
 */
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