<?php
    header('Content-type: application/json; charset=utf-8');
	require('server.php');
	require('opentok.php');
	
	$server = new Server();
	$server->startApp();
	
	switch($_GET['o']) {
		case 'add':
			$fb_id = $_GET['fb_id'];
			$workshop_id = $_GET['w_id'];
			
			$response =$server->registerStudent($fb_id, $workshop_id);
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
		case 'classroom':
			require('fbook.php');
			// Get fb id from db
			$facebook_array = $facebook->api('/1088730508', 'GET');
			$facebook_name = $facebook_array['name'];
			
			$opentok = new OpenTok();
			$response = $opentok->generate($facebook_name);
        	
			break;
		default:
			$response = array('status'=>'400','message'=>'command not known');
			break;
	}
	
	$results =  json_encode($response);
	
	$server->closeApp();
	echo $results;
?>