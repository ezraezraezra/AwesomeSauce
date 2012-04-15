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
var fbObj =  {
	status : false,
	id : '0',
	token : '',
	displayAvatar : function() {
		console.log(this.id);
		var image_url;
		
		if(this.id != '0') {
			image_url = "https://graph.facebook.com/"+ this.id +"/picture?type=normal";
		}
		else {
			image_url = "assets/img/user_50.png";
		}
		$(".container_content_header_fb").css( {
													backgroundImage : "url("+ image_url +")",
													display : 'block'
												});
		
	},
	postToWall : function(user_type, title, date) {
		 var message;
		 if(user_type == 'admin') {
			 message = "Giving an online workshop about "+ title +" on "+ date +".";
		 }
		 else if(user_type == 'user') {
		 	message = "Going to an online workshop about "+title+" on "+ date +".";
		 }
		$.get('php/fbook.php', {
			token: this.token,
			id: this.id,
			message : message
		}, function(data) {
			// Do nothing
		});
	}
}

	
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '306799199381663',
        status     : true, 
        cookie     : true,
        xfbml      : true,
        oauth      : true,
      });
      
      
      
      /*
       * Modified from
       * http://facebook.stackoverflow.com/questions/3548493/how-to-detect-when-facebooks-fb-init-is-complete
       */
      FB.getLoginStatus(function(response) {
      	if(response.status != 'connected') {
      		fbObj.status = false;
      		fbObj.displayAvatar();
      	}
      	else {
      		fbLoginStatus = true;
      		fbObj.status = true;
      		fbObj.id = response.authResponse.userID;
      		fbObj.token = response.authResponse.accessToken;
      		fbObj.displayAvatar();
      	}
      });
    };
    (function(d){
       var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
       js = d.createElement('script'); js.id = id; js.async = true;
       js.src = "//connect.facebook.net/en_US/all.js";
       d.getElementsByTagName('head')[0].appendChild(js);
     }(document));

