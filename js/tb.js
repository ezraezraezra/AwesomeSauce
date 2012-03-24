/**
 * @author Ezra Velazquez
 */

console.log("hello world");

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
		console.log(token);
		console.log(sessionId);
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
				subscriberProps = {width: 300, 
                                            height: 250, 
                                            subscribeToAudio: true};
			}
			else {
				console.log("other");
				// a student, figure out what to do
				
				/*
				$(".student_container").each(function(i) {
					console.log(i);
					if($(this).children(":first").html() == 'Paul McCartney') {
						console.log("inside");
						//$(this).children(":first").html(connection_data['name']);
						//console.log("yes");
						$(this).children(":last").attr("id", "user_"+i);
						$(this).css("zIndex", "100");
						video_feed = "user_"+i;
						//video_feed = "video_feed_instructor";
						subscriberProps = {width: 150, 
		                                            height: 100, 
		                                            subscribeToAudio: true};
					}
					else {
						console.log($(this).children(":first").html());
					}
				});
				*/
				// var counter = 0;
				// $(".student_container").each(function(i) {
					// console.log("inside when trying to create publisher");
					// counter = i;
				// });
				
				var module = '<div class="student_container">'+
							 	'<span class="student_name classroom_labels"></span>'+
								'<div class="video_feed_student" id="user_'+student_counter+'"></div>'+
							'</div>';
				$(".students_container").append(module);
				video_feed = "user_"+student_counter;
				$("#"+video_feed).parent().css("zIndex", 100);
				//$obj = $(".students_container").children(":last").children(":last");
				
				subscriberProps = {width: 150, height: 100, subscribeToAudio: true};
				student_counter +=1;
				
			}
			console.log(video_feed);
			
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
		//console.log(stream);
		connection_data = getConnectionData(stream['connection']);
		console.log(connection_data);
		if(connection_data['u_type'] == 'admin') {
			$(".instructor_name.classroom_labels").html(connection_data['name']);
			// create the video thing here
			//$obj = $("video_feed_instructor");
			video_feed = "video_feed_instructor";
			label_set = true;
			subscriberProps = {width: 300, height: 250, subscribeToAudio: true};
		}
		else {
			// figure out what to do with students
			// Populate one of many subscribers
			
			//
			// Old method of putting them on
			//
			// $(".student_container").each(function() {
// 				
				// if($(this).children(":first").html() == '') {
					// $(this).children(":first").html(connection_data['name']);
					// //console.log("yes");
					// // create the video thing here
					// $obj = $("");
				// }
				// else {
					// console.log("no");
				// }
				// //console.log($(this));
			// });
			
			
		}
		
		
		// Check if this is the stream that I am publishing, and if so do not publish.
		if (stream.connection.connectionId == session.connection.connectionId) {
			if(label_set == false) {
				console.log("HIERE");
				console.log(video_feed);
				$("#user_0").parent().children(":first").html("HIHIH"+connection_data['name']);
			}
			return;
		}
		
		
		//
			// New Method
			//
			// var module = '<div class="student_container">'+
						 	// '<span class="student_name classroom_labels">'+ connection_data['name'] +'</span>'+
							// '<div class="video_feed_student"></div>'+
						// '</div>';
			// $(".students_container").html(module);
			// $obj = $(".students_container").children(":last").children(":last");
		if(label_set == false) {	
			var counter = 0;
				$(".student_container").each(function(i) {
					counter = i;
				});
				
				var module = '<div class="student_container">'+
							 	'<span class="student_name classroom_labels">'+ connection_data['name'] +'</span>'+
								'<div class="video_feed_student" id="user_'+student_counter+'"></div>'+
							'</div>';
				$(".students_container").append(module);
				video_feed = "user_"+student_counter;
		
				student_counter +=1;
				
				subscriberProps = {width: 150, height: 100, subscribeToAudio: true};
		}
		
		
		var subscriberDiv = document.createElement('div'); // Create a div for the subscriber to replace
		subscriberDiv.setAttribute('id', stream.streamId); // Give the replacement div the id of the stream as its id.
		document.getElementById(video_feed).appendChild(subscriberDiv);
		//$obj.append(subscriberDiv);
		subscribers[stream.streamId] = session.subscribe(stream, subscriberDiv.id, subscriberProps);
	}

	function show(id) {
		document.getElementById(id).style.display = 'block';
	}

	function hide(id) {
		document.getElementById(id).style.display = 'none';
	}
	
	function getConnectionData(connection) {
	    try {
	        connectionData = JSON.parse(connection.data);
	    } catch(error) {
	        connectionData = eval("(" + connection.data + ")" );
	    }
	    return connectionData;
	}
	
	return {
		init : function() {
			search = window.location.search.substring(1).split("&");
			//values = new Array();
			for(var i = 0; i < search.length; i++) {
				pairs = search[i].split("=");
				values[pairs[0]] = pairs[1];
				console.log(values[pairs[0]]+ "<="+ pairs[0]);
			}

			
			$.get('../php/server_ajax.php', {
				"o" : "classroom",
				"uid" : values['uid'],
				"type" : values['type'],
				"wid" : values['wid'],	
			}, function(data) {
				console.log(data);
				//sessionId = data.session[0];
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
