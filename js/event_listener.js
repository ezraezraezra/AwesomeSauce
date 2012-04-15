/**
 * @author Ezra Velazquez
 * 
 * Project:     AwesomeSauce
 * Description: Live telepresence micro-workshop platform          
 * Website:     http://awsmsauce.org
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        May 2011
 * 
 */

var LISTENER = function() {
	var DEBUG = true;
	var teach_view = 'index.php?d=teach';
	var learn_view = 'index.php?d=learn';
	var home_view = 'index.php';
	
	var $button = '';
	var $modal = '';
	var $modal_backdrop = '';
	
	var date_picker_status = false;
	var next_function;
	
	function log(message) {
		if(DEBUG === true) {
			console.log(message);
		}
	}
	
	
	
	function _facebookLoginScreen(callback) {
		if(fbObj.status == false) {
			$("#modal_form").css("display", "none");
			$(".modal_facebook_login").css("display", "block");
			next_function = callback;
		}
		else {
			callback();
		}
			
	}
	
	function _facebookLoginButton() {
		FB.login(function(response) {
			
			
			if(response.status == 'connected' || response.status =="200") {
				fbObj.status = true;
				fbObj.id = response.authResponse.userID;
				fbObj.token = response.authResponse.accessToken;
				fbObj.displayAvatar();
				
				$(".modal_facebook_login").css("display", "none");
				next_function();
			}
			
		}, {scope : 'publish_stream'});
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
		
		setURL();
	}
	
	function _displayModal(view, $object) {
		if(view == 'fill') {
			//set modal to be filled
			$(".modal_learn").css("display", "none");
			$(".modal_teach").css("display", "block");
			$(".modal form :input").removeAttr('readonly');
			$(".modal form :input[name=date]").attr('readonly', true);
			$(".intructor_field").css("display", "none");
			$(".participants_field").css("display", "none");
			
			$modal.fadeIn();
		}
		else if(view == 'view') {
			//set modal to read-only
			$(".modal_teach").css("display", "none");
			$(".modal_learn").css("display", "block");
			$(".modal form :input").attr('readonly', true);
			$(".intructor_field").css("display", "block");
			$(".participants_field").css("display", "block");
			
			// Only display 'register' if user is not teaching or leading the workshop
			var display_bottom = true;
			$(".user_details_wids").children().each(function() {
				if($(this).text() == $object.attr("id")) {
					display_bottom = false;
				}
			});
			
			if(display_bottom == false) {
				$(".modal_bottom").css("display", "none");
			}
			else {
				$(".modal_bottom").css("display", "block");
			}

			//Workshop id
			$(".modal_button_bottom.modal_learn.button").attr("wid", $object.attr("id"));
 			
			//Title
			$(".modal form :input[name=title]").val($object.children(":nth-child(2)").children(":nth-child(1)").text());
 			
			//Technology
			var tech_list = [];
			$object.children(":nth-child(2)").children(":nth-child(3)").find("li").each(function() { tech_list.push($(this).text()) });
			var tech_list_string = tech_list.join(", ");
			$(".modal form :input[name=technology]").val(tech_list_string);
 			
			//Description
			$(".modal form :input[name=descrition]").val($object.children(":nth-child(4)").children(":nth-child(1)").text());
 			
			//Date & Time
			var date = $object.children(":nth-child(4)").children(":nth-child(2)").text();
			var time = $object.children(":nth-child(4)").children(":nth-child(3)").text();
			$(".modal form :input[name=date]").val(date + " @ " + time);
 			
			//Instructor
			var image_src = $object.children(":nth-child(1)").children(":nth-child(1)").children(":nth-child(1)").css("backgroundImage");
			$(".modal_instructor_img_update").css("backgroundImage", image_src);
			$(".modal_instructor_name").text($object.children(":nth-child(2)").children(":nth-child(2)").text());
			$(".modal_instructor_update_rating_good").text($object.children(":nth-child(2)").children(":nth-child(2)").attr("rg"));
			$(".modal_instructor_update_rating_bad").text($object.children(":nth-child(2)").children(":nth-child(2)").attr("rb"));
			
			//Participants
			$(".modal_participants_info_amount").text($object.children(":nth-child(4)").children(":nth-child(4)").text());
			_displayRandomParticipants($object.children(":nth-child(4)").children(":nth-child(5)"));
			
			//User Classroom urls
			_displayMyUrls($object);

			$modal.fadeIn();
		}
		
	}
	
	function _displayRandomParticipants($obj) {
		var participants = new Array();
		var max_display = 7;
		var display_ids = new Array();
		
		$obj.children().each(function(index) {
			var user = $(this).text();
			participants.push(user);
		});
		
		if(participants.length < max_display) {
			max_display = participants.length;
		}
		
		for(x = 0; x < max_display; x++) {
			var random = Math.floor(Math.random() * participants.length);
			display_ids.push(participants[random]);
			participants.splice(random,1);
		}
		
		for(x = 0; x < display_ids.length; x++) {
			var user_img = "<div class='modal_participants_img' style='background-image: url(\"https://graph.facebook.com/"+ display_ids[x] +"/picture?type=square\");' />";
			$(".modal_participants_img_container").append(user_img);
		}
		
	}
	
	function _displayMyUrls($object) {
		if(fbObj.id.length != 1) {
			if(window.location.search.indexOf("d=me") != -1) {
				var class_type = $object.parent().parent().children(":nth-child(1)").children(":nth-child(1)").text();
				var u_id;
				var w_id = $object.attr("id");
				var u_type;
				
				if(class_type.indexOf("Attending") == 0) {
					u_id = $(".user_details").attr("sid");
					u_type = "user";
				}
				else if(class_type.indexOf("Leading") == 0) {
					u_id = $(".user_details").attr("iid");
					var u_type = "admin";
				}
				
				var url = window.location.origin + "" + window.location.pathname + "?d=classroom&uid="+u_id+"&type="+u_type+"&wid="+w_id;
				var data = new Array();
				data['url_values'] = new Array();
				data['url_values']['u_id'] = u_id;
				data.url_values.type = u_type;
				data.url_values.w_id = w_id;
				
				_fillModalUrl(data);
			}
		}
	}
	
	function _createWorkshop($object) {
		$.getJSON("https://graph.facebook.com/"+fbObj.id, function(data) {
			var data_to_send = $object.serialize()+"&fb_id="+fbObj.id+"&o=register&name="+data.name;		
			$.get('php/server_ajax.php?'+data_to_send, function(data) {
				// Should probably add a 'progress bar'
				
				_fillModalUrl(data);
				fbObj.postToWall('admin', $("input[name=title]").val(), $("input[name=date]").val());
			});
		});
		
		$("#modal_form").css("display", "none");
		$(".modal_progress").css("display", "block");
	}
	
	function _registerForWorkshop($object) {
		$.get('php/server_ajax.php', {
			"o" : "add",
			"fb_id" : fbObj.id,
			"w_id" : $object.attr("wid")	
		}, function(data) {
			// Should probably add a 'progress bar'
			
			_fillModalUrl(data);
			fbObj.postToWall('user', $("input[name=title]").val(), $("input[name=date]").val());
		});
		
		$("#modal_form").css("display", "none");
		$(".modal_progress").css("display", "block");
	}
	
	function _hideModal() {
		$modal.fadeOut(function() { _cleanModal(); });
	}
	
	function _cleanModal() {
		$(".modal form :input").val("");
		
		$(".modal_participants_img_container").html("");
		$(".modal_progress").css("display", "none");
		$(".modal_facebook_login").css("display", "none");
		$(".workshop_url").css("display", "none");
		$("#modal_form").css("display", "block");
		$(".modal_bottom").css("display", "block");
	}
	
	function _buttonListener($object) {
		switch($.trim($object.text()))
		{
			case 'create':
				_displayModal('fill', $object);
				break;

			case 'Register':
				_facebookLoginScreen(function() {
					_registerForWorkshop($object);
				});
				
				//_registerForWorkshop($object);
				break;
			case 'Login with Facebook':
				_facebookLoginButton();
				break;
			case 'award point':
				_awardPoint($object);
				break;
			case 'teach a workshop':
				_displayModal('fill', $object);
				break;
			default:
				// Do nothing
				break;	
		}
	}
	
	function _awardPoint($object) {
		var value = parseInt($(".instructor_rating").text(), 10);
		$(".instructor_rating").text(value + 1);
		$object.fadeOut('600');
		
		var w_id = $object.attr("wid");
		$.get('php/server_ajax.php', {
			o   : 'instructor',
			a   : 'push',
			wid : w_id
		}, function(data) {
			// Do nothing
		});
	}
	
	function _formListener(e, $object) {
		e.preventDefault();
		
		switch($object.attr("id")) {
			case 'container_content_header_search_form':
				// Search for workshop
				window.location = "?&q=" + $object.children("[type=text]").val();
				break;
			case 'modal_form':
				// Create workshop
				
				/*
				 * Facebook check here
				 */
				_facebookLoginScreen(function() {
					_createWorkshop($object);
				});
								
				break;
			// Chat interface
			case 'chat_form':
				var user_text = $object.children(":first").val();
				$object.children(":first").val("");
				
				//NODE JS STUFF HERE
				Chat.sendMessage(user_text);
				
				break;
			default:
				// Do nothing
				break;
		}
		
	}
	
	function _fillModalUrl(data) {
		var url = window.location.origin + "" + window.location.pathname + "?d=classroom&uid="+data.url_values.u_id+"&type="+data.url_values.type+"&wid="+data.url_values.w_id;
		var url_date = $("input[name=date]").val();
		
		$(".modal_url_url").val(url);
		$(".modal_url_date").html(url_date);
		
		$("#modal_form").css("display", "none");
		$(".modal_progress").css("display", "none");
		$(".workshop_url").css("display", "block");
		
	}
	
	function _dateTimeListener($object, initial) {
		if($(".intructor_field").css("display") == 'none') {
			// Do nothing
		}
		else {
			$("#ui-datepicker-div").css("display", "none");
		}
	}
	
	function _avatarListener() {
		if(fbObj.id != '0') {
			window.location = home_view + "?d=me";
		}
		else {
			FB.login(function(response) {
				if(response.status == 'connected' || response.status =="200") {
					fbObj.status = true;
					fbObj.id = response.authResponse.userID;
					fbObj.token = response.authResponse.accessToken;
					fbObj.displayAvatar();
				}
				
			}, {scope : 'publish_stream'});
		}
		
	}
	
	
	function init() {
		$button = $('.button');
		$modal = $('.modal_container');
		$modal_backdrop = $('.modal_backdrop');
		$form = $('form');
		
		$modal_backdrop.on("click", function() { _hideModal(); });
		
		$(".modal form :input[name=date]").click(function() { _dateTimeListener($(this), true); });
		$(".modal form :input[name=date]").datetimepicker({ ampm: true, stepMinute: 15, timeFormat: 'h:mm TT' });
		
		$(".modal_url_url").on("click", function() { $(this).select(); });
		
		
		// New stuff
		$(".container_content_header_logo").on("click", function() { _homeListener('home')});
		$form.on("submit", function(e) { _formListener(e,$(this)); });
		$button.on("click", function() { _buttonListener($(this)); });
		$(".container_content_body_group_result").on("click", function() { _displayModal('view', $(this)); })
												 .on("mouseenter", function() { $(this).css("backgroundColor", "#3DA6F4"); }) 
												 .on("mouseleave", function() { $(this).css("backgroundColor", "#F0BA32"); });
		$(".container_content_header_fb").on("click", function() { _avatarListener(); });
	}
	
	$(document).ready(function() {
		init();
	});
	
}();
