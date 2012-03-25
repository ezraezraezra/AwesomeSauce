/**
 * @author Ezra Velazquez
 */

var LISTENER = function() {
	var DEBUG = true;
	var teach_view = 'layout_tester.php?d=teach';
	var learn_view = 'layout_tester.php?d=learn';
	var home_view = 'layout_tester.php';
	
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
		else if(view == 'home'){
			new_view = home_view;
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
			
			//Only display 'register' if not in 'teach view'
			if(window.location.search.indexOf('d=teach') != -1) {
				$(".modal_button_bottom.modal_learn.button").css("display", "none");
			}
			else {
				$(".modal_button_bottom.modal_learn.button").css("display", "block");
			}
			
			//Workshop id
			log($parent.attr("wid"));
			$(".modal_button_bottom.modal_learn.button").attr("wid", $parent.attr("wid"));
			
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
		
		
		// Call server
		
		_hideModal();
	}
	
	function _registerForWorkshop($object) {
		$.get('../php/server_ajax.php', {
			"o" : "add",
			"fb_id" : fbObj.id,
			"w_id" : $object.attr("wid")	
		}, function(data) {
			log(data);
			// Should probably add a 'progress bar'
			
			_fillModalUrl(data);
			//_hideModal();
		});
	}
	
	function _hideModal() {
		log('modal: need to clean values');
		
		$modal.fadeOut(function() { _cleanModal(); });
	}
	
	function _cleanModal() {
		$(".modal form :input").val("");
		
		$(".workshop_url").css("display", "none");
		$("#modal_form").css("display", "block");
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
				//_createWorkshop($object);
				break;
			case 'Register':
				log("Register to workshop");
				_registerForWorkshop($object);
				break;
			default:
				log($.trim($object.text()));
				break;	
		}
	}
	
	function _formListener(e, $object) {
		e.preventDefault();
		switch($object.attr("id")) {
			// Search for workshop
			case 'container_content_header_learn_search_form':
				window.location = learn_view + "&q=" + $object.children("[type=text]").val();
				break;
			// Create workshop
			case 'modal_form':
				console.log("modal_form called. You want to create");
				var data_to_send = $object.serialize()+"&fb_id="+fbObj.id+"&o=register&name=Ezra Velazquez";
				console.log(data_to_send);
				//console.log(fbObj.id);
				$.get('../php/server_ajax.php?'+data_to_send, function(data) {
					console.log(data);
					// Should probably add a 'progress bar'
					
					
					_fillModalUrl(data);
					
				});
				
				break;
			// Chat interface
			case 'chat_form':
				console.log($object);
				console.log("this is the chat module");
				
				var user_text = $object.children(":first").val();
				console.log("you typed: "+user_text);
				$object.children(":first").val("");
				
				//NODE JS STUFF HERE
				console.log(Chat.enabled());
				
				break;
			default:
				console.log($object);
				break;
		}
		
	}
	
	function _fillModalUrl(data) {
		var url = window.location.origin + "" + window.location.pathname + "?d=classroom&uid="+data.url_values.u_id+"&type="+data.url_values.type+"&wid="+data.url_values.w_id;
		console.log(url);
		var url_date = $("input[name=date]").val();
		
		$(".modal_url_url").val(url);
		$(".modal_url_date").html(url_date);
		
		// Display modal window that contains url
		// When user clicks outside of it, remove it
		// and bring it back to normal
		
		
		
		$("#modal_form").css("display", "none");
		$(".workshop_url").css("display", "block");
		
		//_hideModal();
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
		
		
		$("#container_logo").on("click", function() { _homeListener('home')});
		$button.on("click", function() { _buttonListener($(this)); });
		$modal_backdrop.on("click", function() { _hideModal(); });
		//$("form").submit(function(e) { e.preventDefault(); });
		$form.on("submit", function(e) { _formListener(e,$(this)); });
		
		$(".modal form :input[name=date]").click(function() { _dateTimeListener($(this), true); });
		$(".modal form :input[name=date]").datetimepicker({ ampm: true, stepMinute: 15, timeFormat: 'h:mm TT' });
		
		$(".modal_url_url").on("click", function() { $(this).select(); });
	}
	
	$(document).ready(function() {
		init();
	});
	
}();
