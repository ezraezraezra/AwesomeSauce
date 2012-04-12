<?php
    include("php/fbook.php");
	$display = $_GET['d']; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>AwsmSauce | Share a Skill ~ Learn a Few</title>
		<!--
  ___                          _____                       
 / _ \                        /  ___|                      
/ /_\ \__      _____ _ __ ___ \ `--.  __ _ _   _  ___  ___ 
|  _  |\ \ /\ / / __| '_ ` _ \ `--. \/ _` | | | |/ __|/ _ \
| | | | \ V  V /\__ \ | | | | /\__/ / (_| | |_| | (__|  __/
\_| |_/  \_/\_/ |___/_| |_| |_\____/ \__,_|\__,_|\___|\___|
		-->
		<link rel="stylesheet" type="text/css" href="assets/css/overall.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/scheduler.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/content_header.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/modal.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/classroom.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/result_cell.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/lib/jquery-ui-timepicker-addon.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/lib/smoothness/jquery-ui-1.8.18.custom.css">
		<script type="text/javascript" src="js/lib/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/lib/jquery-ui-1.8.18.custom.min.js"></script>
		<script type="text/javascript" src="js/event_listener.js"></script>
		<script type="text/javascript" src="js/lib/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-30794173-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head>
	<body>
		<?php printFacebokHTML(); ?>
		<div id="container_main">
			<?php
				if($display != 'classroom') {
					include("php/modal.php");
				}
			?>
			<div id="container_middle">
				<?php
					if($display == 'classroom') {
						include('php/classroom.php');
					}
					else {
						include("php/scheduler.php");
					}
				?>
			</div>
			<?php include("php/footer.php"); ?>
		</div>
	</body>
</html>



