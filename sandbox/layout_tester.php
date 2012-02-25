<?php
	$display = $_GET['d']; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>AwesomeSauce</title>
		<link rel="stylesheet" type="text/css" href="../assets/css/overall.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/index.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/search_bar.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/scheduler.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/scheduler_group.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/post_bar.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/modal.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/classroom.css" />
	</head>
	<body>
		
		<div id="container_main">
			<?php 
				if($display == 'learn' || $display == 'teach') {
					include("../php/modal.php");
				}
				include("../php/header.php");
			?>
			<div id="container_middle">
				<?php
					if($display == 'learn' || $display == 'teach') {
						include('../php/scheduler.php');
					} 
					else if($display == 'classroom') {
						include('../php/classroom.php');
					}
					else {
						include("../php/home.php");
					}
				?>
			</div>
			<?php include("../php/footer.php"); ?>
		</div>
	</body>
</html>



