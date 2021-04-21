<?php
	include_once 'includes/header.php';
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
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
                <div class="title-text"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Review Assessments</div>
                <hr class="divider">
                <!--
				<button class="review-questions-btn title-text">
                    <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                    Review Assessments
                </button>
				<button class="edit-questions-btn title-text">
                    <a href="all-questions.php">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Review Questions
                    </a>
				</button>
                -->
				<div class="completed-box" id="completed-box">
					<h2><?php echo $assessment->num_complete_assessments($logged_user_id); ?></h2>
					<p>Completed Assessments</p>
				</div>
				<div class="incomplete-box">
					<h2><?php echo $assessment->num_incomplete_assessment($logged_user_id); ?></h2>
					<p>Incomplete Assessments</p>
				</div>
				<div class="total-box">
					<h2><?php echo $logged_user->num_followers($logged_user_id); ?></h2>
					<p>Total Assessments</p>
				</div>
				<div class="completed-area">
                    <h5>Completed Assessments</h5>
					<?php if ($assessment->num_complete_assessments($logged_user_id) == 0){
					    echo '<div class="alert alert-warning" role="alert">No assessments completed yet</div>';
                    }
                    elseif ($assessment->num_complete_assessments($logged_user_id) >= 1) {?>
                    <div class="table-responsive">
						<table class="dt">
						  <thead>
							  <tr>
								<th>Name</th>
    							<th>Email</th>
    							<th>Biz Name</th>
    							<th>Biz Location</th>
    							<th>Biz Phase</th>
    							<th>Industry</th>
    							<th>Employees</th>
    							<th>Turnover</th>
    							<th>Biz Rating</th>
    							<th>Action</th>
    						  </tr>
						  </thead>
						  <tbody>
						  	<?php $assessment->display_complete_a($logged_user_id); ?>
						  </tbody>
						</table>
                    </div>
                    <?php } ?>
				</div>
				<div class="incompleted-area">
                    <h5>Incomplete Assessments</h5>
					<?php if ($assessment->num_incomplete_assessment($logged_user_id) == 0) {
                        echo '<div class="alert alert-warning" role="alert">No assessments to show yet</div>';
                    }
                    elseif ($assessment->num_incomplete_assessment($logged_user_id) >= 1) {?>
					<div class="table-responsive">
						<table class="dt">
	                    	<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Biz Name</th>
									<th>Biz Location</th>
									<th>Biz Phase</th>
									<th>Industry</th>
									<th>Employees</th>
									<th>Turnover</th>
									<th>Areas not completed</th>
		                   		</tr>
	                    	</thead>
							<tbody>
								<?php $assessment->display_incomplete_a($logged_user_id); ?>
							</tbody>
	                	</table>
					</div>
                    <?php } ?>
				</div>

                <!-- Modal -->
                <!--
				<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Summary Report <span  id="user-name" class="badge badge-info">Name</span></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<div id="chartContainer" style="height: 370px; width: 100%;"></div>
								</div>
								<div class="divider"></div>
								<div class="col-12">
									<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button class="full-report-btn btn btn-primary"><a href="report.php">full report</a></button>
						</div>
						</div>
					</div>
                </div>
                -->
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
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
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
		$('table.dt').DataTable({
			"bPaginate": false,
			"info": false,
		});
	</script>
</body>
</html>
