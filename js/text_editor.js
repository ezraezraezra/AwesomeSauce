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

var TextEditor = function() {
	var unique_key = '';
	
	function _setUniqueEditorKey() {
		var values = new Array();
		var search = window.location.search.substring(1).split("&");
		for(var i = 0; i < search.length; i++) {
			pairs = search[i].split("=");
			values[pairs[0]] = pairs[1];
		}
		return 'RPKqbhusON_' + values['wid'];
	}
	
	function _startEtherpad() {
		$("#blackboard_module").pad({'padId'            : unique_key,
									 'host'             : 'http://pad.tn',
									 'baseUrl'          : '/p/',
									 'showControls'     : false,
									 'showChat'         : false,
									 'showLineNumbers'  : true,
									 'userName'         : 'guest',
									 'useMonospaceFont' : false,
									 'noColors'         : false,
									 'hideQRCode'       : true,
									 'width'            : 460,
									 'height'           : 310,
									 'border'           : 0,
									 'borderStyle'      : 'solid'
									}
		);
	}
	
	return {
		init : function() {
			unique_key = _setUniqueEditorKey();
			_startEtherpad();
		}
	}
}();
