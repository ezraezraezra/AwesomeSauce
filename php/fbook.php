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
				</script><div class="fb-login-button" data-scope="email" style="display:none;">Login with Facebook</div>';
		
		echo $print;		
	}
	

?>
