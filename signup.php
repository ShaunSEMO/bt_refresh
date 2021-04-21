<?php
	// Including Files
	include 'includes/class_database.php';
	include 'includes/class_registration.php';
	include 'includes/function_register_validation.php';
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak | Sign up</title>
	<link rel="icon" href="images/logo_short.png">

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <link rel="stylesheet" href="css/font-awesome.css"><!-- font-awesome-icons -->
    <link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
    <style>
        #code {
            display: block;
        }
    </style>
</head>

<body>
	<section class="w3l-form-36">
		<div class="form-36-mian section-gap">
			<div class="wrapper">
				<div class="form-inner-cont">
					<h3>Create account</h3>
					<!--- validation alert-->
					<?php
						if(!empty($error)){
							foreach($error as $errors){
								echo '
								<div class="alert alert-danger" role="alert">
									'.$errors.'
						  		</div>
								';
							}
						}
					?>

					<form id="signup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form">
                        <!-- name input-->
                        <div class="form-input">
                            <span class="fa fa-user-o" aria-hidden="true"></span> <input type="text" name="name" placeholder="Full name" required />
                        </div>

                        <!-- email or username input-->
						<div class="form-input">
							<span class="fa fa-envelope-o" aria-hidden="true"></span> <input type="email" name="username" placeholder="Email/username" required />
						</div>

						<!--- password input -->
						<div class="form-input">
							<span class="fa fa-key" aria-hidden="true"></span><input type="password" name="password" placeholder="Password"
								required />
						</div>

						<!-- confirm password input-->
						<div class="form-input">
							<span class="fa fa-key" aria-hidden="true"></span> <input type="password" name="rpassword" placeholder="Confirm Password"
								required />
						</div>
						<p></p>

						<!-- Consutant or Entrepreneur option -->
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
						  <label class="btn btn-secondary active">
						    <input type="radio" name="type" id="option1" value="entrepreneur" checked> Entrepreneur
						  </label>
						  <label class="btn btn-secondary">
						    <input type="radio" name="type" id="option2" value="consultant"> Consultant
						  </label>
						</div>
						<!--- consultant code input -->
                        <div id="code" class="form-input">
                            <input type="password" name="consultant_code" placeholder="Consultant code"/>
                        </div>
                        <br>
						<button type="submit" class="signup-button btn btn-primary btn-lg btn-block">sign up</button>

					</form>

					<p class="signup">Already a member? <a href="login.php" class="signuplink">Sign in</a></p>
				</div>

				<!-- copyright -->
				<div class="copy-right">
					<p>© 2021 Biz Tweak. All rights reserved
				</div>
				<!-- //copyright -->
			</div>
		</div>
	</section>
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            /* ------ Sign up page --------*/
            $("#option1").click(function() {
                $('#code').show("slow");
            });

            $("#option2").click(function() {
                $('#code').hide();
            });
        });
    </script>
</body>
</html>
