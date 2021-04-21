<?php 
    include 'includes/header.php';
	global $scores;
	$user_id = $assessment->first_follower($logged_user_id);
    $user_scores = $scores->score_q($user_id);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Biz Tweak | Report</title>
	<!-- Meta tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- //Meta tags -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
	<link rel="stylesheet" href="css/font-awesome.css"><!-- font-awesome-icons -->
	<link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainerConcept", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Business Concept"
	},
	axisY: {
		title: "Scores Average (%)"
	},
	data: [{        
		type: "column",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Business Concept Scores Average",
		dataPoints: [
			{ y: <?php echo $user_scores[0]['average'] ?>, label: "<?php echo $user_scores[0]['type'] ?> "},
			{ y: <?php echo $user_scores[1]['average'] ?>, label: "<?php echo $user_scores[1]['type'] ?> " },
			{ y: <?php echo $user_scores[2]['average'] ?>, label: "<?php echo $user_scores[2]['type'] ?> " },
			{ y: <?php echo $user_scores[3]['average'] ?>, label: "<?php echo $user_scores[3]['type'] ?> " },
			{ y: <?php echo $user_scores[4]['average'] ?>, label: "<?php echo $user_scores[4]['type'] ?> " },
			{ y: <?php echo $user_scores[5]['average'] ?>, label: "<?php echo $user_scores[5]['type'] ?> " },
			{ y: <?php echo $user_scores[6]['average'] ?>, label: "<?php echo $user_scores[6]['type'] ?> " },
            { y: <?php echo $user_scores[7]['average'] ?>, label: "<?php echo $user_scores[7]['type'] ?> " },
            { y: <?php echo $user_scores[8]['average'] ?>, label: "<?php echo $user_scores[8]['type'] ?> " },
            { y: <?php echo $user_scores[9]['average'] ?>, label: "<?php echo $user_scores[9]['type'] ?> " },
            { y: <?php echo $user_scores[10]['average'] ?>, label: "<?php echo $user_scores[10]['type'] ?> "}
		]
	}]
});
chart.render();

var chart = new CanvasJS.Chart("chartContainerStructure", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Business Structure"
	},
	axisY: {
		title: "Scores Average (%)"
	},
	data: [{        
		type: "column",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Business Structure Scores Average",
		dataPoints: [
            { y: <?php echo $user_scores[11]['average'] ?>, label: "<?php echo $user_scores[11]['type'] ?> "},
            { y: <?php echo $user_scores[12]['average'] ?>, label: "<?php echo $user_scores[12]['type'] ?> " },
            { y: <?php echo $user_scores[13]['average'] ?>, label: "<?php echo $user_scores[13]['type'] ?> " },
            { y: <?php echo $user_scores[14]['average'] ?>, label: "<?php echo $user_scores[14]['type'] ?> " },
            { y: <?php echo $user_scores[15]['average'] ?>, label: "<?php echo $user_scores[15]['type'] ?> " },
            { y: <?php echo $user_scores[16]['average'] ?>, label: "<?php echo $user_scores[16]['type'] ?> " },
            { y: <?php echo $user_scores[17]['average'] ?>, label: "<?php echo $user_scores[17]['type'] ?> " },
            { y: <?php echo $user_scores[18]['average'] ?>, label: "<?php echo $user_scores[18]['type'] ?> " },
            { y: <?php echo $user_scores[19]['average'] ?>, label: "<?php echo $user_scores[19]['type'] ?> " },
            { y: <?php echo $user_scores[20]['average'] ?>, label: "<?php echo $user_scores[20]['type'] ?> " },
            { y: <?php echo $user_scores[21]['average'] ?>, label: "<?php echo $user_scores[21]['type'] ?> " },
            { y: <?php echo $user_scores[22]['average'] ?>, label: "<?php echo $user_scores[22]['type'] ?> " },
            { y: <?php echo $user_scores[23]['average'] ?>, label: "<?php echo $user_scores[23]['type'] ?> " },
            { y: <?php echo $user_scores[24]['average'] ?>, label: "<?php echo $user_scores[24]['type'] ?> " },
            { y: <?php echo $user_scores[25]['average'] ?>, label: "<?php echo $user_scores[25]['type'] ?> " },
            { y: <?php echo $user_scores[26]['average'] ?>, label: "<?php echo $user_scores[26]['type'] ?> " }
		]
	}]
});
chart.render();

}
</script>
</head>
<body style="background: #EDF5E1">
    <!--Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark info-color">
	  <a class="navbar-brand" href="consultant.php">Biztweak | Assessment Report</a>
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
			<a class="nav-link" href="signed-out.php">
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
                    <p>Consultant</p>
                    <hr class="divider">
                    <h6><span class="badge badge-secondary"><?php echo $logged_user->num_followers($logged_user_id); ?></span> Entrepreneurs</h6>
                </div>
                <div class="completed-assess-box">
                    <p>Completed Assements</p>
                    <hr class="divider">
                    <?php $assessment->display_complete_box($logged_user_id); ?>
                </div>
            </div>
            <div class="col-9">
				<h4>Business Concept</h4>
				<!-- scores area -->
				<div id="scores-area">
					<div id="chartContainerConcept" style="height: 300px; width: 100%;"></div>
					<div class="priority-elements-box">
						<h4>Priority Elements</h4>
						<p class="font-weight-bold">Value Proposition: <?php echo round($user_scores[0]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'value proposition').' of '.$scores->num_value_questions()?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'value proposition')?>
						<p class="font-weight-bold">Customer Segments  <?php echo round($user_scores[1]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'customer segments').' of '.$scores->num_segment_question()?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'customer segments')?>
						<p class="font-weight-bold">Proof of Concept  <?php echo round($user_scores[10]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'proof of concept').' of '.$scores->num_concept_question()?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'proof of concept')?>
					</div>
					<!-- Highest performing Areas-->
					<div class="priority-elements-box">
						<h4>High Performing Area</h4>
						<?php $scores->display_high_top3($user_id, 'concept'); ?>
					</div>

					<!-- Major gaps -->
					<div class="priority-elements-box">
						<h4>Major Gaps</h4>
						<?php $scores->display_low_top3($user_id, 'concept'); ?>
					</div>
					
					<h4>Business Structure</h4>
					<div id="chartContainerStructure" style="height: 300px; width: 100%;"></div>
					<div class="priority-elements-box">
						<h4>Priority Elements</h4>
						<p class="font-weight-bold">Talent: <?php echo round($user_scores[13]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'ownership and mindset').' of '.$scores->num_sec_questions('ownership and mindset')?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'ownership and mindset')?>
						<p class="font-weight-bold">Business Process Management: <?php echo round($user_scores[12]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'business process management').' of '.$scores->num_sec_questions('business process management')?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'business process management')?>
						<p class="font-weight-bold">Financial Management: <?php echo round($user_scores[16]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'financial management').' of '.$scores->num_sec_questions('financial management')?>)</p>
						<?php echo $scores->display_q_negative($user_id, 'financial management')?>
					</div>
					<!-- Highest performing Areas-->
					<div class="priority-elements-box">
						<h4>High Performing Area</h4>
						<?php $scores->display_high_top3($user_id, 'structure'); ?>
					</div>
					
					<!-- Major gaps -->
					<div class="priority-elements-box">
						<h4>Major Gaps</h4>
						<?php $scores->display_low_top3($user_id, 'structure'); ?>
					</div>
				</div>
			</div> <!-- / scores area -->
        </div>
	</div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>
</html>