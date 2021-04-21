<?php
    include 'includes/function_signout.php';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>ACCESS DENIED!!</title>
		<!-- Meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <link href="css/font-awesome.css" rel="stylesheet"><!-- font-awesome-icons -->
    <link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
</head>

<body>
	<section class="w3l-form-36">
		<div class="form-36-mian section-gap">
			<div class="wrapper">
				<div class="form-inner-cont">
					<h3>Access to this page denied!</h3>
					<p>Sorry you do not have access to this page because you are not signed in or registered</p>
					<form action="index.php">
						<button href="index.php" type="submit" class="btn btn-primary btn-lg btn-block theme-button">sign in</button>
					</form>
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