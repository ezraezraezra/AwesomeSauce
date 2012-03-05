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
	
	var date_picker_status = false;
	
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
		
		//_facebookLoginClick(function() {setURL();});
		setURL();
	}
	
	function _displayModal(view, $object) {
		if(view == 'fill') {
			log('modal:fill was called');
			//set modal to be filled
			$(".modal_learn").css("display", "none");
			$(".modal_teach").css("display", "block");
			$(".modal form :input").removeAttr('readonly');
			$(".modal form :input[name=date]").attr('readonly', true);
			$(".intructor_field").css("display", "none");
			
			
			
			$modal.fadeIn();
		}
		else if(view == 'view') {
			log('modal:view was called');
			
			//set modal to read-only
			$(".modal_teach").css("display", "none");
			$(".modal_learn").css("display", "block");
			$(".modal form :input").attr('readonly', true);
			$(".intructor_field").css("display", "block");
			
			$parent = $object.parent();
			
			//Title
			$(".modal form :input[name=title]").val($parent.children(":nth-child(3)").children(":nth-child(1)").text());
			
			//Technology
			var tech_list = [];
			$parent.children(":nth-child(3)").children(":nth-child(2)").find("li").each(function() { tech_list.push($(this).text()) });
			console.log(tech_list);
			var tech_list_string = tech_list.join(", ");
			$(".modal form :input[name=technology]").val(tech_list_string);
			
			//Description
			$(".modal form :input[name=descrition]").val($parent.children(":nth-child(5)").text());
			
			//Date & Time
			var date = $parent.children(":nth-child(1)").children(":nth-child(1)").text();
			var time = $parent.children(":nth-child(1)").children(":nth-child(2)").text();
			$(".modal form :input[name=date]").val(date + " @ " + time);
			
			//Instructor
			var image_src = $parent.children(":nth-child(2)").children(":nth-child(1)").attr("src");
			$(".modal_instructor_img_update").attr("src", image_src);
			$(".modal_instructor_name").text($parent.children(":nth-child(2)").children(":nth-child(2)").text());
			$(".modal_instructor_update_rating_good").text($parent.children(":nth-child(2)").children(":nth-child(2)").attr("rg"));
			$(".modal_instructor_update_rating_bad").text($parent.children(":nth-child(2)").children(":nth-child(2)").attr("rb"));
			
			
			$modal.fadeIn();
		}
		
	}
	
	function _createWorkshop() {
		log('modal:crate workshop called');
		
		_hideModal();
	}
	
	function _hideModal() {
		log('modal: need to clean values');
		_cleanModal();
		$modal.fadeOut();
	}
	
	function _cleanModal() {
		$(".modal form :input").val("");
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
				_displayModal('fill', $object);
				break;
			case 'More Info':
				_displayModal('view', $object);
				break;
			case 'Create':
				_createWorkshop();
				break;	
		}
	}
	
	function _formListener(e, $object) {
		e.preventDefault();
		switch($object.attr("id")) {
			case 'container_content_header_learn_search_form':
				window.location = learn_view + "&q=" + $object.children("[type=text]").val();
				break;
			default:
				console.log($object);
				break;
		}
		
	}
	
	function _dateTimeListener($object, initial) {
		if($(".intructor_field").css("display") == 'none') {
			
		}
		else {
			$("#ui-datepicker-div").css("display", "none");
		}
	}
	
	function init() {
		$button = $('.button');
		$modal = $('.modal_container');
		$modal_backdrop = $('.modal_backdrop');
		$form = $('form');
		
		$button.on("click", function() { _buttonListener($(this)); });
		$modal_backdrop.on("click", function() { _hideModal(); });
		//$("form").submit(function(e) { e.preventDefault(); });
		$form.on("submit", function(e) { _formListener(e,$(this)); });
		
		$(".modal form :input[name=date]").click(function() { _dateTimeListener($(this), true); });
		$(".modal form :input[name=date]").datetimepicker({ ampm: true, stepMinute: 15, timeFormat: 'h:mm TT' });
	}
	
	$(document).ready(function() {
		init();
	});
	
}();
