<?php 
	include 'function_signup.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		  background-color: #9ac259;
		  overflow: hidden;
		}
		img {
		  width: 100%;
		}
        .pt-imgs {
            width: 150px;
            margin: 10px;
        }
		.form-box {
		  width: 450px;
		  background-color: #fff;
		  margin: 8% auto;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="../images/smme-logo.png" />
                <img class="pt-imgs" src="../images/smme-partners-1.png"/>
                <img class="pt-imgs" src="../images/smme-partners-2.png"/>
                <img class="pt-imgs" src="../images/smme-partners-3.png"/>
            </div>
            <div class="col-sm">
            <div class="sidenav">
                <div class="form-box">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2 class="text-center">Membership Registration Form</h2>
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
                <p>Company Name: <input name="name" class="form-control" /><p>
                <p>Address: <input name="address" class="form-control" /></p>
                <p>Contact number: <input name="number" class="form-control" /></p>
                <p>Email: <input name="email" class="form-control" /></p>
                <p>Fax: <input name="fax" class="form-control" /></p>
                <p>Website: <input name="website" class="form-control" /></p>
				<p>VAT Number <input name="vat" class="form-control"/></p>
                <p>
                    Business Structure
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="type" id="option1" value="cc" autocomplete="off" checked> CC
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="type" id="option2" value="ngo" autocomplete="off"> NGO
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="type" id="option3" value="pty_ltd" autocomplete="off"> PTY LTD
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="type" id="option4" value="other" autocomplete="off"> Other
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="type" id="option5" value="org" autocomplete="off"> Organization
                    </label>
                    </div>
                </p>
                <button type="submit">Register</button>
				</form>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.5.1.slim.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>