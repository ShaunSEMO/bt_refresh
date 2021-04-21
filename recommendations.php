<?php
	include 'includes/header.php';
	if (isset($_GET['get_details'])) {
		$user_id = $_GET['get_details'];
		$user_info = $logged_user->user_info_by_id($user_id);
		$e_id = $user_info->user_id;
		$business_info = $logged_user->business_info($e_id);
		$biz_rating = $assessment->get_biz_rating($e_id);
		$user_info->biz_rating = $biz_rating;
		echo json_encode([
			'user' => $user_info,
			'biz' => $business_info
		]);
		exit;
	}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Biz Tweak | Consultant</title>
	<!-- Meta tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- //Meta tags -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"><!-- font-awesome-icons -->
	<link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
	<script src="js/Chart.bundle.js"></script>
  	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body style="background: #EDF5E1">
	<!--Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark info-color">
		<a class="navbar-brand" href="consultant.php"><span class="d-inline d-md-none">Dashboard</span><span class="d-none d-md-inline">Biztweak | Consultant Dashboard</span></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
		aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
  			<a class="nav-link" href="recommendations.php">
  			  <i class="fa fa-file" aria-hidden="true"></i> Recommendations
  			  <span class="sr-only">(current)</span>
  			</a>
  		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="#">
			  <i class="fa fa-user" aria-hidden="true"></i> Profile
			  <span class="sr-only">(current)</span>
			</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="signed-out.php">
			  <i class="fa fa-sign-out" aria-hidden="true"></i> Sign out
			  </a>
		  </li>
		</ul>
	  </div>
	</nav>
	<!--/.Navbar -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="admin-box">
					<i id="user-img" class="fa fa-user" aria-hidden="true"></i>
					<h2><?php echo $user_info->name; ?></h2>
					<p>Consultant code:<span class="font-weight-bold"> <?php echo $user_info->code?></span></p>
					<hr class="divider">
					<h6><span class="badge badge-secondary"><?php echo $logged_user->num_followers($logged_user_id); ?></span> Entrepreneurs</h6>
				</div>
				<div class="followers-box">
					<?php $logged_user->display_followers($logged_user_id); ?>
				</div>
			</div>
			<div class="col-md-9">
                <div class="title-text"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Received Recommendations</div>
                <hr class="divider">
                <h4>Filter:</h4>
                <form action="" class="form-inline mb-3" method="post">
                    <div class="form-group">
                        <select name="exp" class="form-control mr-2" required>
                            <option value="">EXP</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="filter" value="Filter">
                        &nbsp;&nbsp;&nbsp;
                        <?php if (isset($_POST['filter'])): ?>
                            <a href="recommendations.php" class="btn btn-warning">Show All</a>
                        <?php endif; ?>
                    </div>
                </form>
                </h3>
                <div class="table-responsive">
					<table class="table table-bordered bg-white">
	                    <thead>
	                        <tr class="bg-white">
								<th>Name</th>
	                            <th>EXP</th>
	                            <th>New&nbsp;Challenges</th>
	                            <th>Old&nbsp;Challenges</th>
	                            <th>New&nbsp;Solutions</th>
	                            <th>Old&nbsp;Solutions</th>
								<th>Recommendations</th>
								<th>Willing to Pay</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php
	                        if (isset($_POST['filter']) AND !empty($_POST['filter'])) {
	                            $exp = $_POST['exp'];
	                            $recommendations = [];
	                            $res = $db->query("SELECT * FROM `surveys` WHERE `consultant_id`='$logged_user_id' AND exp='$exp'");
	                            while($row = mysqli_fetch_assoc($res)){
	                                $recommendations[] = $row;
	                            }
	                        }else{
	                            $recommendations = [];
	                            $res = $db->query("SELECT * FROM `surveys` WHERE `consultant_id`='$logged_user_id'");
	                            while($row = mysqli_fetch_assoc($res)){
	                                $recommendations[] = $row;
	                            }
	                        }
	                        foreach ($recommendations as $key => $recommendation) :
								$rec_user_info = $logged_user->user_info($recommendation['user_id']);
								?>
	                        <tr class="bg-white">
								<td><?= $rec_user_info->name ?></td>
	                            <td><?= $recommendation['exp']; ?></td>
	                            <td><?= $recommendation['challenges_now']; ?></td>
	                            <td><?= $recommendation['challenges_before']; ?></td>
	                            <td><?= $recommendation['solutions_now']; ?></td>
								<td><?= $recommendation['solutions_before']; ?></td>
								<td><?= $recommendation['recommendations']; ?></td>
	                            <td>$<?= $recommendation['price']; ?></td>
	                        </tr>
	                    <?php endforeach; ?>
	                    <?php if (count($recommendations)<1): ?>
	                        <tr>
	                            <td colspan="5" class="text-center">
	                                Nothing found!
	                            </td>
	                        </tr>
	                    <?php endif; ?>
	                    </tbody>
	                </table>
                </div>
			</div>
		</div>
	</div>

	<nav class="navbar fixed-bottom navbar-light bg-light">
  		<a class="navbar-brand" href="#">© 2020 Biz Tweak. All rights reserved</a>
	</nav>

	<div class="modal fade in" id="user-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Entrepreneur Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

            </div>
        </div>
    </div>


	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/style.js"></script>
	<script type="text/javascript">
		$('.fetch-user').click((e)=>{
			$this = $(e.target);
			id = $this.data('id');
			// alert(id);
			$.ajax({
				url: '<?= $_SERVER['PHP_SELF'] ?>?get_details='+id,
				success: (r)=>{
					data = JSON.parse(r);
					html = `<table>
					<tr><th>Name</th><td>${data.user.name}</td></tr>
					<tr><th>Location</th><td>${data.user.location}</td></tr>
					<tr><th>Biz Name</th><td>${data.biz.name}</td></tr>
					<tr><th>Biz Phase</th><td>${data.biz.stage}</td></tr>
					<tr><th>Industry</th><td>${data.biz.industry}</td></tr>
					<tr><th>Employees</th><td>${data.biz.employees}</td></tr>
					<tr><th>Turnover</th><td>${data.biz.turnover}</td></tr>
					<tr><th>Overall Score</th><td>${data.user.biz_rating}</td></tr>
					</table>`;
					$("#user-modal .modal-body").html(html);
				}
			});
		});
	</script>
</body>
</html>
