<?php

	define('306799199381663', '306799199381663');

	//uses the PHP SDK.  Download from https://github.com/facebook/php-sdk
	require 'lib/facebook.php';
	
	$facebook = new Facebook(array(
	  'appId'  => '306799199381663',
	  'secret' => 'eec82b681dc914623dbbf623f8d2915f',
	));
	
	$facebook_userId = $facebook->getUser();
	
				// if($facebook_userId) {
	//$facebook_userInfo = $facebook->api('/' + $facebook_userId);
	      		// echo $userInfo['name'];
			// }
			// else {
				// echo 'facebook id not set';
			// }
			
	function printFacebokHTML() {
		$print = '';
		$print.='<div id="fb-root"></div>
				<script type="text/javascript" src="../js/fb.js">
				</script><div class="fb-login-button" data-scope="publish_stream" style="display:none;">Login with Facebook</div>';
		
		echo $print;		
	}
	
	function facebookPost($token, $u_id, $message, $facebook) {
		// Solution from:
		# http://stackoverflow.com/questions/7991180/programmatically-login-to-facebook-and-post-to-page-wall
		$attachment = array(
			'access_token' => $token,
			'message'      => $message,
			'name'         => 'AwesomeSauce',
			'caption'      => 'Share a Skill ~ Learn a Few',
			'link'         => 'http://ezraezraezra.com',
			'description'  => 'Online face-to-face workshops for the developer community',
			'picture'      => 'http://ezraezraezra.com/thesis/assets/img/fb_post.png'
		); 	
		 $facebook->api('/'.$u_id.'/feed', 'POST', $attachment);
		 
		 echo 'done posting to wall';
	}
	
	
	if(isset($_GET['token'])) {
		facebookPost($_GET['token'], $_GET['id'], $_GET['message'], $facebook);
	}
	

?>
