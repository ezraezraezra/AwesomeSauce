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
var fbObj =  {
	status : false,
	id : '0',//'1088730508',
	token : '',
	displayAvatar : function() {
		console.log(this.id);
		$(".container_content_header_fb").css( {
													backgroundImage : "url('https://graph.facebook.com/"+ this.id +"/picture?type=normal')",
													display : 'block'
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
      	console.log(response);
      	console.log(response.status);
      	if(response.status != 'connected') {
      		fbObj.status = false;
      	}
      	else {
      		fbLoginStatus = true;
      		fbObj.status = true;
      		console.log("in here");
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

