<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'includes/class_registration.php';
    $user = new registration();
    if (isset($_POST['final'])) {
        $user_id = $_SESSION['SESS_USER_ID'];
        $type = $_POST['type'];
        $code = $_POST['code'];
        $res = $db->query("SELECT user_id FROM users WHERE code = '$code'");
        if (empty($code) AND $type == '2') {
            $code = "biz".rand(100,1000);
            $query = "UPDATE users SET user_type='$type', code='$code' WHERE user_id='$user_id'";
            $db->query($query);
            header('Location: consultant.php');
            exit;
        }else{
            if($res->num_rows > 0){
                $c_id = $db->fetch_assoc($res)['user_id'];
                $query = "UPDATE users SET user_type='$type' WHERE user_id='$user_id'";
                if ($db->query($query)) {
                    $query = "INSERT INTO relation(entrepreneur_id, consultant_id) VALUES('$user_id', '$c_id')";
                    $db->query($query);
                    $_SESSION['SESS_TYPE'] = $type;
                    header('Location: entrepreneur.php');
                    exit;
                }else{
                    echo 'Something went wrong.';
                }
            }else{
                echo 'Invalid boz code.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak</title>
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
				<div class="form-inner-cont" style="margin: 0 auto;">
					<h3>Complete your registration</h3>
					<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="signin-form">

                        <div>
                            <br>
                            <label style="margin-bottom: 0;">You wanna register as:</label>
                            <select class="form-control" id="user-type" name="type" required>
                                <option value="">Choose</option>
                                <option value="3">Entrepreneur</option>
                                <option value="2">Consultant</option>
                            </select>
                        </div>
                        <div id="biz">
                            <br><label>Biz Code</label>
                            <div class="form-input">
                                <span class="fa fa-key"></span> <input name="code" type="text">
                            </div>
                        </div>

						<div class="login-remember d-grid">
							<button name="final" type="submit" class="btn theme-button">Next</button>
						</div>
					</form>
				</div>
				</div>

				<!-- copyright -->
				<div class="copy-right text-center">
					<p>© 2020 Biz Tweak. All rights reserved
				</div>
				<!-- //copyright -->
			</div>
		</div>
	</section>
    <script src="js/jquery.js" charset="utf-8"></script>
    <script type="text/javascript">
        $("#biz").hide();
        $("#user-type").on('change', (e)=>{
            if($(e.target).val() == '3'){
                $("#biz").show();
                $("#biz input").attr('required','required');
            }else{
                $("#biz").hide();
                $("#biz input").removeAttr('required');
            }
        });
    </script>
</body>
</html>
