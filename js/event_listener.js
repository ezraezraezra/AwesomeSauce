/**
 * @author Ezra Velazquez
 * 
 * Project:     AwesomeSauce
 * Description: Live telepresence micro-workshop platform          
 * Website:     http://awesomesauce.opentok.com
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        May 2011
 * 
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

/*	
	function _facebookLoginClick(callback) {
		if(fbObj.status == false) {
			FB.login(function(response) {
				console.log("FB.login called");
				console.log(response);
				console.log("user id: " + response.authResponse.userID);
				console.log("access token: "+ response.authResponse.accessToken);
				fbObj.id = response.authResponse.userID;
				fbObj.token = response.authResponse.accessToken;
				fbObj.status = true;
				
				//callback();
			});
		}
		else {
			console.log("already loged in from previous session");
			console.log("user id: " + fbObj.id);
			console.log("access token: "+ fbObj.token);
			
			
			
			
			//callback();
		}
	}
*/	
	
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
			
			console.log($object);
			
			// $parent = $object.parent();
// 			
			// //Only display 'register' if not in 'teach view'
			// if(window.location.search.indexOf('d=teach') != -1) {
				// $(".modal_button_bottom.modal_learn.button").css("display", "none");
			// }
			// else {
				// $(".modal_button_bottom.modal_learn.button").css("display", "block");
			// }
// 			
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
			log($object.attr("id"));
			$(".modal_button_bottom.modal_learn.button").attr("wid", $object.attr("id"));
 			
			//Title
			$(".modal form :input[name=title]").val($object.children(":nth-child(2)").children(":nth-child(1)").text());
 			
			//Technology
			var tech_list = [];
			$object.children(":nth-child(2)").children(":nth-child(3)").find("li").each(function() { tech_list.push($(this).text()) });
			console.log(tech_list);
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
			
			//User Classroom urls
			_displayMyUrls($object);

			
			$modal.fadeIn();
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
				console.log(url);
				
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
			console.log(data);
			var data_to_send = $object.serialize()+"&fb_id="+fbObj.id+"&o=register&name="+data.name;		
			console.log("data_to_send"+ data_to_send);
			$.get('../php/server_ajax.php?'+data_to_send, function(data) {
				console.log(data);
				// Should probably add a 'progress bar'
				
				
				_fillModalUrl(data);
			});
		});
		
		
		// var data_to_send = $object.serialize()+"&fb_id="+fbObj.id+"&o=register&name="+fbObj.;		
		// console.log("data_to_send"+ data_to_send);
		// $.get('../php/server_ajax.php?'+data_to_send, function(data) {
			// console.log(data);
			// // Should probably add a 'progress bar'
// 			
// 			
			// _fillModalUrl(data);
// 			
		// });
		 $("#modal_form").css("display", "none");
		 $(".modal_progress").css("display", "block");
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
		$("#modal_form").css("display", "none");
		$(".modal_progress").css("display", "block");
	}
	
	function _hideModal() {
		log('modal: need to clean values');
		
		$modal.fadeOut(function() { _cleanModal(); });
	}
	
	function _cleanModal() {
		$(".modal form :input").val("");
		
		$(".modal_progress").css("display", "none");
		$(".modal_facebook_login").css("display", "none");
		$(".workshop_url").css("display", "none");
		$("#modal_form").css("display", "block");
	}
	
	function _buttonListener($object) {
		switch($.trim($object.text()))
		{
			case 'create':
				_displayModal('fill', $object);
				break;

			case 'Register':
				log("Register to workshop");
				
				_facebookLoginScreen(function() {
					_registerForWorkshop($object);
				});
				
				
				//_registerForWorkshop($object);
				break;
			case 'Login with Facebook':
				console.log("login called");
				_facebookLoginButton();
				break;
			case 'award point':
				console.log("award point called");
				_awardPoint($object);
				break;
			case 'teach a workshop':
				_displayModal('fill', $object);
				break;
			default:
				log($.trim($object.text()));
				break;	
		}
	}
	
	function _awardPoint($object) {
		var value = parseInt($(".instructor_rating").text(), 10);
		$(".instructor_rating").text(value + 1);
		$object.fadeOut('600');
		
		var w_id = $object.attr("wid");
		$.get('../php/server_ajax.php', {
			o   : 'instructor',
			a   : 'push',
			wid : w_id
		}, function(data) {
			console.log(data);
		});
	}
	
	function _formListener(e, $object) {
		e.preventDefault();
		console.log("form called");
		
		switch($object.attr("id")) {
			case 'container_content_header_search_form':
				// Search for workshop
				window.location = "?&q=" + $object.children("[type=text]").val();
				break;
			case 'modal_form':
				// Create workshop
				console.log("modal_form called. You want to create");
				//var data_to_send = $object.serialize()+"&fb_id="+fbObj.id+"&o=register&name=Ezra Velazquez";
				//var data_to_send = $object.serialize();
				//console.log(data_to_send);
				//console.log(fbObj.id);
				
				
				/*
				 * Facebook check here
				 */
				_facebookLoginScreen(function() {
					_createWorkshop($object);
				});
				
/*				
				$.get('../php/server_ajax.php?'+data_to_send, function(data) {
					console.log(data);
					// Should probably add a 'progress bar'
					
					
					_fillModalUrl(data);
					
				});
*/				
				break;
			// Chat interface
			case 'chat_form':
				//console.log($object);
				//console.log("this is the chat module");
				
				var user_text = $object.children(":first").val();
				//console.log("you typed: "+user_text);
				$object.children(":first").val("");
				
				//NODE JS STUFF HERE
				//console.log(Chat.enabled());
				Chat.sendMessage(user_text);
				
				
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
		
		$("#modal_form").css("display", "none");
		$(".modal_progress").css("display", "none");
		$(".workshop_url").css("display", "block");
		
		fbObj.postToWall(data.url_values.type, $("input[name=title]").val(), $("input[name=date]").val());
		
		//_hideModal();
	}
	
	function _dateTimeListener($object, initial) {
		if($(".intructor_field").css("display") == 'none') {
			
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
		//$("form").submit(function(e) { e.preventDefault(); });
		
		
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
