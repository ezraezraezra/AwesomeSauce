/**
 * @author Ezra Velazquez
 */

var LISTENER = function() {
	var DEBUG = true;
	var teach_view = 'layout_tester.php?d=teach';
	var learn_view = 'layout_tester.php?d=learn';
	
	var $button = '';
	var $modal = '';
	var $modal_backdrop = '';
	
	function log(message) {
		if(DEBUG === true) {
			console.log(message);
		}
	}
	
	function _facebookLoginClick(callback) {
		if(fbObj.status == false) {
			FB.login(function(response) {
				console.log("FB.login called");
				console.log(response);
				console.log("user id: " + response.authResponse.userID);
				console.log("access token: "+ response.authResponse.accessToken);
				fbObj.id = response.authResponse.userID;
				fbObj.token = response.authResponse.accessToken;
				callback();
			});
		}
		else {
			console.log("already loged in from previous session");
			console.log("user id: " + fbObj.id);
			console.log("access token: "+ fbObj.token);
			callback();
		}
	}
	
	function _homeListener(view) {
		var new_view = '';
		
		if(view == 'teach') {
			log("home: teach clicked");
			new_view = teach_view;
		}
		else if(view == 'learn'){
			new_view = learn_view;
		}
		
		function setURL() {
			window.location = new_view;
		}
		
		_facebookLoginClick(function() {setURL();});
	}
	
	function _displayModal(view) {
		if(view == 'fill') {
			log('modal:fill was called');
			$modal.fadeIn();
		}
		else if(view == 'view') {
			log('modal:view was called');
			$modal.fadeIn();
		}
	}
	
	function _createWorkshop() {
		log('modal:crate workshop called');
		
		_hideModal();
	}
	
	function _hideModal() {
		log('modal: need to clean values');
		$modal.fadeOut();
	}
	
	function _buttonListener($object) {
		switch($.trim($object.text()))
		{
			case 'Teach':
				_homeListener('teach');
				break;
			case 'Learn':
				_homeListener('learn');
				break;
			case 'Post New Workshop':
				_displayModal('fill');
				break;
			case 'More Info':
				_displayModal('view');
				break;
			case 'Create':
				_createWorkshop();
				break;		
		}
	}
	
	function init() {
		$button = $('.button');
		$modal = $('.modal_container');
		$modal_backdrop = $('.modal_backdrop');
		
		$button.on("click", function() { _buttonListener($(this)); });
		$modal_backdrop.on("click", function() { _hideModal(); });
	}
	
	$(document).ready(function() {
		init();
	});
	
}();
