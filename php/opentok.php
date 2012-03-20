<?php
	require_once 'lib/API_Config.php';
	require_once 'lib/OpenTokSDK.php';
	
	class OpenTok {
		
		function OpenTok() {
			
		}
		
		function generate($name) {
			$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);

			// Pull this from the server when wanting the workshop
			$session = $apiObj->create_session($_SERVER["REMOTE_ADDR"]);
			
			$role = RoleConstants::PUBLISHER; // Or set to the correct role for the user.
			// Get username from the FB server?
			$metadata =  '{"name": "'.$name.'"}';
			$token_user = $apiObj->generate_token($session->getSessionId(), $role, NULL, $metadata); // Replace with the correct session ID
			$session_id = $session->getSessionId();
					
			$arr = array('session'=>$session_id, 'token'=>$token_user);
			return $arr;
		}
	}
?>