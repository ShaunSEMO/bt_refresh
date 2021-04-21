<?php
	include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak | Profile</title>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- //Meta tags -->
    <link href="css/font-awesome.css" rel="stylesheet"><!-- font-awesome-icons -->
    <link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
	<link rel="stylesheet" type="text/css" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            var view_profile = document.getElementById('view-profile');
            var edit_profile = document.getElementById('edit-profile');

            $("#edit").click(function(){
                $(edit_profile).show();
                $(view_profile).hide();
            });
            $("#view").click(function(){
                $(view_profile).show();
                $(edit_profile).hide();
                $( "#view-profile" ).load( "profile.php #view-profile" );
            });
            $('form').on("submit", function(event) {
                event.preventDefault();
                var form_type = 'save-profile';
                var formValues = $(this).serialize();

                $.post("includes/function_update.php", formValues, function(data){
                    // Display the returned data in browser
                    $("#alert").html(data);
                });
            })
        });
    </script>
</head>

<body style="background: #EDF5E1;padding-bottom: 80px;">
	<!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark info-color">
      <a class="navbar-brand" href="entrepreneur.php">Biztweak | Entreprneur Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
        aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fa fa-user" aria-hidden="true"></i> Profile
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fa fa-sign-out" aria-hidden="true"></i> Sign out
              </a>
          </li>
        </ul>
      </div>
    </nav>
<!--/.Navbar -->
	<div class="container">
		<div class="row">
			<div class="col-3">
				<div class="admin-box">
					<i id="user-img" class="fa fa-user" aria-hidden="true"></i>
					<h2><?php echo $user_info->name; ?></h2>
					<p>Entrepreneur</p>
					<hr class="divider">
					<h6><?php echo $business_info->name; ?></h6>
				</div>
			</div>
			<div class="col-9">
			<div class="title-text">My Profile</div>
				<hr class="divider">
                <div id="alert"></div>
                <div class="profile-box-info" id="view-profile">
                    <p>Full Name: <span><?php echo $user_info->name; ?></span></p>
                    <p>Designation: <span><?php echo $user_info->designation; ?></span></p>
                    <p>Location: <span><?php echo $user_info->location; ?></span></p>
                    <p>Education Background: <span><?php echo $user_info->education; ?></span></p>
                    <p>Failed Before: <span><?php echo $user_info->status; ?></span></p>
                    <p>Type: <span><?php echo $user_info->biz_type; ?></span></p>
                    <p>Stage in Business: <span><?php echo $user_info->biz_stage ?></span></p>
					<p>Business Bio: <span><?php echo $user_info->bio; ?></span></p>
					<p>Offering: <span><?php echo $user_info->offering; ?></span></p>
                    <p>Purpose: <span><?php echo $user_info->choice; ?></span></p>
                    <button id="edit"> Edit profile </button>
                </div>
                <div class="profile-box-edit" id="edit-profile">
                    <form method="post">
                        <input type="hidden" name="form_type" value="save-profile">
                        <p>Full Name: <input type="text" name="name" value="<?php echo $user_info->name; ?>"> </p>
                        <p>Designation: <input type="text" name="designation" value="<?php echo $user_info->designation; ?>"> </p>
                        <p>Location: <input type="text" name="location" value="<?php echo $user_info->location; ?>"> </p>
                        <p>Education Background: <input type="text" name="education" value="<?php echo $user_info->education; ?>"> </p>
                        <p>Failed Before: <input type="text" name="status" value="<?php echo $user_info->status; ?>"> </p>
                        <p>Type: <input type="text" name="type" value="<?php echo $user_info->biz_type; ?>"> </p>
                        <p>Stage in Business: <input type="text" name="stage" value="<?php echo $user_info->biz_stage; ?>"></p>
						<p class="mb-5">Business Bio: <textarea name="bio"><?php echo $user_info->bio; ?></textarea></p>
						<p class="mb-5">Offerings: <textarea name="offering"><?php echo $user_info->offering; ?></textarea></p>
                        <p>Purpose:
							<select name="choice">
								<option <?= ($user_info->choice == 'Test my business idea')?'selected':'' ?> value="Test my business idea">Test my business idea</option>
								<option <?= ($user_info->choice == 'Get customers & revenue')?'selected':'' ?> value="Get customers & revenue">Get customers & revenue</option>
									<option <?= ($user_info->choice == 'Understand-Find my target market')?'selected':'' ?> value="Understand-Find my target market">Understand-Find my target market</option>
								<option <?= ($user_info->choice == 'Get my business investor ready')?'selected':'' ?> value="Get my business investor ready">Get my business investor ready</option>
								<option <?= ($user_info->choice == 'Know if I can scale my business')?'selected':'' ?> value="Know if I can scale my business">Know if I can scale my business</option>
								<option <?= ($user_info->choice == 'Improve my employee performance')?'selected':'' ?> value="Improve my employee performance">Improve my employee performance</option>
								<option <?= ($user_info->choice == 'Start a business')?'selected':'' ?> value="Start a business">Start a business</option>
							</select>
						</p>
                        <button type="submit" id="save"> save </button>
                        <button id="view"> View profile </button>
                    </form>
                </div>
			</div>
		</div>
	</div>
	<nav class="navbar fixed-bottom navbar-light bg-light">
  		<a class="navbar-brand" href="#">© 2020 Biz Tweak. All rights reserved</a>
	</nav>
</body>
</html>
