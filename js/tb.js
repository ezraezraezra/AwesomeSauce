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
 * Note:        Original basic functionality code by: TokBox
 * 
 */
var test;

var OpenTok = function() {
	var apiKey = 13249262; // OpenTok sample API key. Replace with your own API key.
	var sessionId = '153975e9d3ecce1d11baddd2c9d8d3c9d147df18'; // Replace with your session ID.
	var token = 'devtoken'; // Should not be hard-coded.
							// Add to the page using the OpenTok server-side libraries.
	var session;
	var publisher;
	var subscribers = {};
	
	var values = new Array();
	var video_feed;
	var student_counter = 0;
	
	//--------------------------------------
	//  LINK CLICK HANDLERS
	//--------------------------------------
	function connect() {
		session.connect(apiKey, token);
	}

	function disconnect() {
		session.disconnect();
	}

	// Called when user wants to start publishing to the session
	function startPublishing() {
		var subscriberProprs;
		if (!publisher) {
			if(values['type'] == 'admin') {
				video_feed = "video_feed_instructor";
				subscriberProps = {width: 340, 
                                            height: 270, 
                                            subscribeToAudio: true};
			}
			else {
				insertStudent('', 'me');				
				$("#"+video_feed).parent().css("zIndex", 100);
				subscriberProps = {width: 150, height: 100, subscribeToAudio: true};
				
			}
			var parentDiv = document.getElementById(video_feed);
			var publisherDiv = document.createElement('div'); // Create a div for the publisher to replace
			publisherDiv.setAttribute('id', 'opentok_publisher');
			parentDiv.appendChild(publisherDiv);
			publisher = session.publish(publisherDiv.id, subscriberProps); // Pass the replacement div id to the publish method
		}
	}

	function stopPublishing() {
		if (publisher) {
			session.unpublish(publisher);
		}
		publisher = null;
	}
	
	//--------------------------------------
	//  OPENTOK EVENT HANDLERS
	//--------------------------------------
	function sessionConnectedHandler(event) {
		startPublishing();
		
		// Subscribe to all streams currently in the Session
		for (var i = 0; i < event.streams.length; i++) {
			addStream(event.streams[i]);
		}
	}

	function streamCreatedHandler(event) {
		// Subscribe to the newly created streams
		for (var i = 0; i < event.streams.length; i++) {
			addStream(event.streams[i]);
		}
	}

	function streamDestroyedHandler(event) {
		// This signals that a stream was destroyed. Any Subscribers will automatically be removed.
		// This default behaviour can be prevented using event.preventDefault()
	}

	function sessionDisconnectedHandler(event) {
		// This signals that the user was disconnected from the Session. Any subscribers and publishers
		// will automatically be removed. This default behaviour can be prevented using event.preventDefault()
		publisher = null;
	}

	function connectionDestroyedHandler(event) {
		// This signals that connections were destroyed
	}

	function connectionCreatedHandler(event) {
		// This signals new connections have been created.
	}

	/*
	If you un-comment the call to TB.addEventListener("exception", exceptionHandler) above, OpenTok calls the
	exceptionHandler() method when exception events occur. You can modify this method to further process exception events.
	If you un-comment the call to TB.setLogLevel(), above, OpenTok automatically displays exception event messages.
	*/
	function exceptionHandler(event) {
		alert("Exception: " + event.code + "::" + event.message);
	}

	//--------------------------------------
	//  HELPER METHODS
	//--------------------------------------

	function addStream(stream) {
		var label_set = false;
		// For testing purposes, it all goes to instructor currently!
		connection_data = getConnectionData(stream['connection']);
		if(connection_data['u_type'] == 'admin') {
			$(".instructor_name.classroom_labels").html(connection_data['name'].replace("+", " ") + " - Instructor");
			// create the video thing here
			video_feed = "video_feed_instructor";
			label_set = true;
			subscriberProps = {width: 340, height: 270, subscribeToAudio: true};
		}
		else {
			// Do nothing
		}
		
		
		// Check if this is the stream that I am publishing, and if so do not publish.
		if (stream.connection.connectionId == session.connection.connectionId) {
			Chat.setName(connection_data['name'].replace("+", " "));
			if(label_set == false) {
				$("#user_me").parent().children(":first").html(connection_data['name'].replace("+", " "));
			}
			return;
		}
		
		if(label_set == false) {	
			insertStudent(connection_data['name'].replace("+", " "), student_counter);
			
			subscriberProps = {width: 150, height: 100, subscribeToAudio: true};
		}
		
		
		var subscriberDiv = document.createElement('div'); // Create a div for the subscriber to replace
		subscriberDiv.setAttribute('id', stream.streamId); // Give the replacement div the id of the stream as its id.
		document.getElementById(video_feed).appendChild(subscriberDiv);
		subscribers[stream.streamId] = session.subscribe(stream, subscriberDiv.id, subscriberProps);
	}

	function show(id) {
		document.getElementById(id).style.display = 'block';
	}

	function hide(id) {
		document.getElementById(id).style.display = 'none';
	}
	
	function getConnectionData(connection) {
		var data = connection.data;
	    try {
	        connectionData = JSON.parse(decodeURIComponent(data));
	    } catch(error) {
	        connectionData = eval("(" + decodeURIComponent(data) + ")" );
	    }
	    return connectionData;
	}
	
	function insertStudent(name, id_tag) {
		video_feed = "user_"+id_tag;
		var module = '<div class="student_container">'+
					 	'<span class="student_name classroom_labels">'+ name +'</span>'+
						'<div class="video_feed_student" id="'+video_feed+'"></div>'+
					'</div>';
		$(".students_container").append(module);
		
		if(id_tag != 'me') {
			student_counter +=1;
		}
		
	}
	
	function _setUniqueVideoKeys() {
		search = window.location.search.substring(1).split("&");
		for(var i = 0; i < search.length; i++) {
			pairs = search[i].split("=");
			values[pairs[0]] = pairs[1];
		}
	}
	
	return {
		init : function() {
			_setUniqueVideoKeys();

			if(values['type'] == 'admin') {
				$(".instructor_rate_button").css("display", "none");
				$(".instructor_rating").css({
					marginLeft  : "auto",
					marginRight : "auto",
					"float"     : "none"
				});
			}
			$(".instructor_rate_button").attr("wid", values['wid']);
			$.get('php/server_ajax.php', {
				"o"   : "instructor",
				"a"   : "pull",
				"wid" : values['wid']
			}, function(data) {
				$(".instructor_rating").html(data.result);
			});		

			$.get('php/server_ajax.php', {
				"o" : "classroom",
				"uid" : values['uid'],
				"type" : values['type'],
				"wid" : values['wid'],	
			}, function(data) {
				$(".container_classroom_header_title").html(data.w_name);
				
				sessionId = data.session;
				token = data.token;
			
				if (TB.checkSystemRequirements() != TB.HAS_REQUIREMENTS) {
					alert("You don't have the minimum requirements to run this application."
						  + "Please upgrade to the latest version of Flash.");
				} else {
					session = TB.initSession(sessionId);	// Initialize session
			
					// Add event listeners to the session
					session.addEventListener('sessionConnected', sessionConnectedHandler);
					session.addEventListener('sessionDisconnected', sessionDisconnectedHandler);
					session.addEventListener('connectionCreated', connectionCreatedHandler);
					session.addEventListener('connectionDestroyed', connectionDestroyedHandler);
					session.addEventListener('streamCreated', streamCreatedHandler);
					session.addEventListener('streamDestroyed', streamDestroyedHandler);
					
					connect();
				}
			});
		}
		
	}
}();
