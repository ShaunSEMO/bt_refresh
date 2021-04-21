<?php
	// Including Files
	include '../includes/class_database.php';
	include '../includes/class_registration.php';
	include '../includes/function_register_validation.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMME Ecosystem Africa</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
		  font-family: sans-serif;
		}

		.container {
		  width: fit-content;
		}

		.sidenav {
		  height: 100vh;
		  background-color: #9ac259;
		  overflow: hidden;
		}
		img {
		  width: 100%;
		}
		.form-box {
		  width: 350px;
		  background-color: #fff;
		  margin: 20% auto;
		  border-radius: 2rem;
		  padding: 15px 10px;
		  transition: all 0.2s ease-in;
		}
		h2 {
		  color: #1b2b3f;
		}
		input[type="text"],
		input[type="password"] {
		  height: 60px;
		  margin: 20px 0;
		  border-radius: 10px;
		  font-size: 1.3rem;
		  background-color: #ccdea9;
		  border: 2px solid #ccdea9;
		  color: #1b2b3f;
		}
		input[type="text"]:focus,
		input[type="password"]:focus {
		  background-color: #ccdea9;
		  border: 2px solid #9ac259;
		  color: #1b2b3f;
		}
		button {
		  border-radius: 10px;
		  height: 60px;
		  width: 100%;
		  border: none;
		  color: #fff;
		  background-color: #9ac259;
		  font-size: 1.5rem;
		  outline: none;
		}
		button:hover {
		  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
			0 17px 50px 0 rgba(0, 0, 0, 0.19);
		  cursor: pointer;
		  outline: none;
		  border: none;
		  outline: none;
		}
		button:focus {
		  outline: none !important;
		}
		button:active {
		  transform: translateY(2px);
		  border: none;
		  outline: none;
		}
		.link {
			margin: 10px 0;
			color:#677c63;
			font-weight:600;
		}
		.link a{
			text-decoration: none;
		}
		.pt-imgs {
			width: 150px;
            margin: 10px;
		}
	</style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <img src="../images/smme-logo.png" />
		  <img class="pt-imgs" src="../images/smme-partners-1.png"/>
		  <img class="pt-imgs" src="../images/smme-partners-2.png"/>
		  <img class="pt-imgs" src="../images/smme-partners-3.png"/>
        </div>
        <div class="col-sm">
          <div class="sidenav">
            <div class="form-box">
			  <h2 class="text-center">SIGN UP</h2>
			  <!--- validation alert--->
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
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			  <input 
			  	type="text"
				name="name"
				placeholder="full name"
				class="form-control"/>
              <input
				type="text"
				name="username"
                placeholder="username / email"
				class="form-control"
              />
              <input
				type="password"
				name="password"
                placeholder="password"
				class="form-control"
              />
			  <input 
			  	type="password" 
				name="rpassword" 
				class="form-control"
				placeholder="confirm password"/>
				<input type="hidden" name="type" value="entrepreneur"/>
				<input type="hidden" name="consultant_code" value="biz845"/>
			  <button type="submit">SIGN UP</button>
			  <p class="link">Alrready have an account? <a href="signup.php">Sign in</a></p>
			</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
