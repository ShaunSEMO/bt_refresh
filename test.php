<?php 
	// Icluding Files
	include 'includes/class_database.php';
	include 'includes/class_registration.php';
	include 'includes/function_register_validation.php';
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak | Sign up</title>
		<!-- Meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <link rel="stylesheet" href="css/font-awesome.css"><!-- font-awesome-icons -->
    <link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
</head>

<body>
	<section class="w3l-form-36">
		<div class="form-36-mian section-gap">
			<div class="wrapper">
				<div class="form-inner-cont">
					<h3>Test Area</h3>
					<?php
					$code = 'biz123';
					$len = strlen($code);
					if ($len == 6){echo 'wrong';}
					echo $len;
					?>
				</div>

				<!-- copyright -->
				<div class="copy-right">
					<p>© 2020 Biz Tweak. All rights reserved
				</div>
				<!-- //copyright -->
			</div>
		</div>
	</section>
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/style.js"></script>
</body>
</html>