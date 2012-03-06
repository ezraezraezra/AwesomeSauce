<?php
    header('Content-type: application/json; charset=utf-8');
	require('server.php');
	
	$server = new Server();
	$server->startApp();
	
	switch($_GET['o']) {
		case 'add':
			$response;
			break;
		case 'register':
			
			// $response = array('status'=>'200','message'=>$server->checkInstructorStatus('1088730508', 'Ezra Velazquez'));
			$title = $_GET['title'];
			$tech = $_GET['technology'];
			$description = $_GET['descrition'];
			$fb_id = $_GET['fb_id'];
			$name = $_GET['name'];
			$date = $_GET['date'];
			
			//$response = array('test'=>$date);
			
			$response =$server->addWorkshop($title, $tech, $description, $date, $fb_id, $name);
			break;
		default:
			$response = array('status'=>'400','message'=>'command not known');
			break;
	}
	
	$results =  json_encode($response);
	
	$server->closeApp();
	echo $results;
?>