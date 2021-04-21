<?php
    include 'includes/class_login.php';
    include 'includes/function_signin-validation.php';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak</title>
	<link rel="icon" href="images/logo_short.png">

		<!-- Meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <link rel="stylesheet" href="css/font-awesome.css"><!-- font-awesome-icons -->
</head>

<body>
	<section class="w3l-form-36">
		<div class="form-36-mian section-gap">
			<div class="wrapper">
				<div class="form-inner-cont">
					<h3>Sign in</h3>
					<!--- validation alert--->
					<?php
						if(!empty($error)){
							foreach($error as $errors){
								echo '
								<div class="validation-alert" role="alert">
									'.$errors.'
								</div>
								';
							}
						}
					?>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="signin-form">

						<div class="form-input">
							<span class="fa fa-envelope-o" aria-hidden="true"></span> <input type="email" name="username" placeholder="Email" required />
						</div>
						<div class="form-input">
							<span class="fa fa-key" aria-hidden="true"></span><input type="password" name="password" placeholder="Password"
								required />
						</div>

						<div class="login-remember d-grid">
							<label class="check-remaind">
								<input type="checkbox">
								<span class="checkmark"></span>
								<p class="remember">Remember me</p>
							</label>
							<button type="submit" class="btn theme-button">Sign in</button>
						</div>
					</form>
					<div class="social-icons">
						<p class="continue"><span>Or</span></p>
						<div class="social-login">
						<a href="social-auth.php?type=Facebook">
							<div class="facebook">
								<span class="fa fa-facebook" aria-hidden="true"></span>
							</div>
						</a>
						<a href="social-auth.php?type=Google">
							<div class="google">
								<span class="fa fa-google-plus" aria-hidden="true"></span>
							</div>
						</a>
					</div>
				</div>
					<p class="signup">Not a member? <a href="signup.php" class="signuplink">Register</a></p>
				</div>

				<!-- copyright -->
				<div class="copy-right">
					<p>© 2021 Biz Tweak. All rights reserved
				</div>
				<!-- //copyright -->
			</div>
		</div>
	</section>
</body>
</html>
