<?php
    include 'includes/header.php';
    $user_scores = array();
    $user_id = $logged_user_id;
    $user_name = $user_info->name;
    $consultant_id = $db->query("SELECT consultant_id FROM relation WHERE entrepreneur_id='$logged_user_id'")->fetch_assoc()['consultant_id'];
    global $scores;
    $user_scores = $scores->score_q($user_id);
    $biz_rating = ($total_avg / (count($user_scores) * 100)) *100;
    $market_viability = $biz_viability = $biz_scalability = $investor_readines = $customer_and_revenue = $finance = $emp_performance = 0;
    foreach($questions_seq as $key => $sets){
        $key_check = strtolower($key);
        $search_array = array_map('strtolower', $sets);
        $search_array = array_map('trim', $search_array);
        foreach ($user_scores as $k => $score) {
            if(in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Understand-Find my target market')){
                $market_viability += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Test my business idea')) {
                $biz_viability += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Know if I can scale my business')) {
                $biz_scalability += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Get my business investor ready')) {
                $investor_readines += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Get customers & revenue')) {
                $customer_and_revenue += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Start a business')) {
                $finance += $score['average'];
            }
            if (in_array(strtolower($score['type']), $search_array) AND $key_check == strtolower('Improve my employee performance')) {
                $emp_performance += $score['average'];
            }

        }
    }
    $market_viability = $market_viability/count($questions_seq['Understand-Find my target market']);
    $biz_viability = $biz_viability/count($questions_seq['Test my business idea']);
    $biz_scalability = $biz_scalability/count($questions_seq['Know if I can scale my business']);
    $investor_readines = $investor_readines/count($questions_seq['Get my business investor ready']);
    $customer_and_revenue = $customer_and_revenue/count($questions_seq['Get customers & revenue']);
    $finance = $finance/count($questions_seq['Start a business']);
    $emp_performance = $emp_performance/count($questions_seq['Improve my employee performance']);
    $percentages = [
        'Biz Rating' => $biz_rating,
        'Market Viability' => $market_viability,
        'Biz Viability' => $biz_viability,
        'Biz Scalability' => $biz_scalability,
        'Investor Readiness' => $investor_readines,
        'Customer & revenue' => $customer_and_revenue,
        'Finance' => $finance,
        'Emp Performance' => $emp_performance,
    ];
    if (isset($_GET['help'])) {
        $db->query("UPDATE users SET help=1 WHERE user_id='$user_id'");
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    if (isset($_POST['recommend'])) {
        $exp = $_POST['exp'];
        $challenges_now = $_POST['challenges_now'];
        $challenges_before = $_POST['challenges_before'];
        $solutions_now = $_POST['solutions_now'];
        $solutions_before = $_POST['solutions_before'];
        $rec = $_POST['rec'];
        $user_id = $_POST['user_id'];
        $consultant_id = $_POST['consultant_id'];
        $price = isset($_POST['quote'])?$_POST['quote']:'';
        $sql = "INSERT INTO `surveys` (`user_id`, `consultant_id`, `exp`, `challenges_now`, `challenges_before`, `solutions_now`, `solutions_before`, `recommendations`, `options`, `price`) VALUES('$user_id', '$consultant_id', '$exp', '$challenges_now', '$challenges_before', '$solutions_now', '$solutions_before', '$rec', '', '$price')";
        $db->query($sql);
        echo "<script>alert('Thank you for conducting survey.');</script>";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    $show = ($db->query("SELECT * FROM `surveys` WHERE `user_id`='$logged_user_id'")->num_rows >0)?false:true;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Biz Tweak | Scores</title>
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
            { y: <?php echo $user_scores[10]['average'] ?>, label: "<?php echo $user_scores[10]['type'] ?> " },
			{ y: <?php echo $user_scores[2]['average'] ?>, label: "<?php echo $user_scores[2]['type'] ?> " },
			{ y: <?php echo $user_scores[4]['average'] ?>, label: "<?php echo $user_scores[4]['type'] ?> " },
			{ y: <?php echo $user_scores[5]['average'] ?>, label: "<?php echo $user_scores[5]['type'] ?> " },
			{ y: <?php echo $user_scores[6]['average'] ?>, label: "<?php echo $user_scores[6]['type'] ?> " },
            { y: <?php echo $user_scores[7]['average'] ?>, label: "<?php echo $user_scores[7]['type'] ?> " },
            { y: <?php echo $user_scores[8]['average'] ?>, label: "<?php echo $user_scores[8]['type'] ?> " },
            { y: <?php echo $user_scores[3]['average'] ?>, label: "<?php echo $user_scores[3]['type'] ?> " },
            { y: <?php echo $user_scores[11]['average'] ?>, label: "<?php echo $user_scores[11]['type'] ?> " },
            { y: <?php echo $user_scores[9]['average'] ?>, label: "<?php echo $user_scores[9]['type'] ?> " }
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
			{ y: <?php echo $user_scores[16]['average'] ?>, label: "<?php echo $user_scores[16]['type'] ?> " }
		]
	}]
});
chart.render();

}
</script>
<style media="screen">
input[type="checkbox"] {
    -webkit-appearance: checkbox;
}

input[type="radio"] {
    -webkit-appearance: radio;
    margin-right: 3px;
}
#info-modal .modal-dialog {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 500px;
    max-width: 100%;
}
</style>
</head>
<body style="background: #EDF5E1">
    <!--Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark info-color">
	  <a class="navbar-brand" href="entrepreneur.php">Biztweak | Assessment Report</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
		aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
		<ul class="navbar-nav ml-auto">
		  <li class="nav-item">
			<a class="nav-link" href="profile.php">
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
            <div class="col-md-3">
                <div class="admin-box">
                    <i id="user-img" class="fa fa-user" aria-hidden="true"></i>
                    <h2><?php echo $user_info->name; ?></h2>
                    <p>Entrepreneur</p>
                    <?php if (!$user_info->help): ?>
                        <button class="glow btn-sm btn btn-primary px-2" data-toggle="modal" data-target="#view-rec-modal">Recommendations</button>
                    <?php else: ?>
                        <button class="glow btn-sm btn btn-primary px-2" data-toggle="modal" data-target="#lms-modal">LMS</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-9">
				<h4> Business Concept <span class="badge badge-secondary"> <?php echo $user_name; ?></span></h4>
				<!-- scores area -->
				<div id="scores-area">
					<div id="chartContainerConcept" style="height: 300px; width: 100%;"></div>
                    <!-- Business diagnosis -->
					<div class="priority-elements-box">
                        <h4 data-toggle="collapse" data-target="#diagnosis-1" class="collapsed">Business Diagnosis</h4>
                        <div class="collapse" id="diagnosis-1">
                            <div class="priority-elements-box">
                                <div>
                                    <h5 data-toggle="collapse" data-target="#priority-1" class="collapsed float-left">Priority Elements</h5>
                                </div>
                                <div class="clearfix"></div>
                                <div class="collapse" id="priority-1">
                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('value proposition');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">value proposition: '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('value proposition');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">Value Proposition: <?php echo round($user_scores[0]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'value proposition').' of '.$scores->num_value_questions()?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'value proposition')?>
                                    <?php echo $scores->display_q_positive($user_id, 'value proposition')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>

                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('customer segments');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">customer segments: '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('customer segments');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">Customer Segments  <?php echo round($user_scores[1]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'customer segments').' of '.$scores->num_segment_question()?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'customer segments')?>
                                    <?php echo $scores->display_q_positive($user_id, 'customer segments')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>


                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('proof of concept');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">proof of concept: '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('proof of concept');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">Proof of Concept  <?php echo round($user_scores[10]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'proof of concept').' of '.$scores->num_concept_question()?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'proof of concept')?>
                                    <?php echo $scores->display_q_positive($user_id, 'proof of concept')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Highest performing Areas-->
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#high-1" class="collapsed">High Performing Area</h5>
                                <div class="collapse" id="high-1">
                                    <?php $scores->display_high_top3($user_id, 'concept'); ?>
                                </div>
                            </div>

                            <!-- Major gaps -->
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#major-1" class="collapsed">Major Gaps</h5>
                                <div class="collapse" id="major-1">
                                    <?php $scores->display_low_top3($user_id, 'concept'); ?>
                                </div>
                            </div>

                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#other-1" class="collapsed">Other Assessments</h5>
                                <div class="collapse" id="other-1">
                                    <?php
                                    $ignore = ['value proposition', 'customer segments', 'proof of concept'];
                                    $lowest3 = array_slice($scores->lowest_top3($user_id, 'concept'), 0, 3);
                                    foreach ($lowest3 as $key => $low) {
                                        $ignore[] = $low['type'];
                                    }
                                    $highest3 = array_slice($scores->highest_top3($user_id, 'concept'), 0, 3);
                                    foreach ($highest3 as $key => $high) {
                                        $ignore[] = $high['type'];
                                    }
                                    $to_display = $user_scores;
                                    foreach ($to_display as $key => $sc) {
                                        if ($key > 11) {
                                            unset($to_display[$key]);
                                        }
                                        if (in_array($sc['type'], $ignore)) {
                                            unset($to_display[$key]);
                                        }
                                    }
                                    $scores->display_others($user_id, $to_display);
                                    ?>
                                </div>
                            </div>
                        </div>
					</div>


					<h4>Business Structure <span class="badge badge-secondary"> <?php echo $user_name; ?></span></h4>
					<div id="chartContainerStructure" style="height: 300px; width: 100%;"></div>
                    <!-- Business diagnosis -->
					<div class="priority-elements-box">
                        <h4 data-toggle="collapse" data-target="#diagnosis-2" class="collapsed">Business Diagnosis</h4>
                        <div class="collapse" id="diagnosis-2">
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#priority-2" class="collapsed">Priority Elements</h5>
                                <div class="collapse" id="priority-2">

                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('ownership and mindset');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">Talent : '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('ownership and mindset');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">Talent: <?php echo round($user_scores[13]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'ownership and mindset').' of '.$scores->num_sec_questions('ownership and mindset')?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'ownership and mindset')?>
                                    <?php echo $scores->display_q_positive($user_id, 'ownership and mindset')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>

                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('business process management');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">business process management: '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('business process management');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">business process management: <?php echo round($user_scores[13]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'ownership and mindset').' of '.$scores->num_sec_questions('ownership and mindset')?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'business process management')?>
                                    <?php echo $scores->display_q_positive($user_id, 'business process management')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>


                                    <?php
                                    $total_q = 0;
                                    $incomp = '';
                                    $q_answered = 0;
                                    $questions = $scores->all_quesion_ids_by_cat('financial management');
                                    $total_q += count($questions);
                                    foreach($questions as $q){
                                        $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                                        if($db->query($query)->num_rows > 0){
                                            $q_answered++;
                                        }
                                    }
                                    if ($q_answered < $total_q) {
                                        $incomp = 'bg-danger p-2 text-white my-2';
                                    }
                                    if (!empty($incomp)) {
                                        echo "<div class='$incomp'>";
                                        echo '<p class="font-weight-bold">financial management: '.round($user_scores[0]['average']).'%</p>';
                                        echo "<p>$q_answered / $total_q Questions answered</p>";
                                        $choice = $scores->find_key('financial management');
                                        echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                                    }else{ ?>
                                        <p class="font-weight-bold">Financial Management: <?php echo round($user_scores[16]['average']); ?>% (<?php echo $scores->num_question_negative($user_id, 'financial management').' of '.$scores->num_sec_questions('financial management')?>)</p>
                                    <?php } ?>
                                    <?php echo $scores->display_q_negative($user_id, 'financial management')?>
                                    <?php echo $scores->display_q_positive($user_id, 'financial management')?>
                                    <?php
                                    if (!empty($incomp)) {
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- Highest performing Areas-->
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#high-2" class="collapsed">High Performing Area</h5>
                                <div class="collapse" id="high-2">
                                    <?php $scores->display_high_top3($user_id, 'structure'); ?>
                                </div>
                            </div>

                            <!-- Major gaps -->
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#major-2" class="collapsed">Major Gaps</h5>
                                <div class="collapse" id="major-2">
                                    <?php $scores->display_low_top3($user_id, 'structure'); ?>
                                </div>
                            </div>
                            <div class="priority-elements-box">
                                <h5 data-toggle="collapse" data-target="#other-2" class="collapsed">Other Assessments</h5>
                                <div class="collapse" id="other-2">
                                    <?php
                                    $ignore = ['talent', 'business process management', 'financial management'];
                                    $lowest3 = array_slice($scores->lowest_top3($user_id, 'structure'), 0, 3);
                                    foreach ($lowest3 as $key => $low) {
                                        $ignore[] = $low['type'];
                                    }
                                    $highest3 = array_slice($scores->highest_top3($user_id, 'structure'), 0, 3);
                                    foreach ($highest3 as $key => $high) {
                                        $ignore[] = $high['type'];
                                    }
                                    $to_display = $user_scores;
                                    foreach ($to_display as $key => $sc) {
                                        if ($key < 12) {
                                            unset($to_display[$key]);
                                        }
                                        if (in_array($sc['type'], $ignore)) {
                                            unset($to_display[$key]);
                                        }
                                    }
                                    $scores->display_others($user_id, $to_display);
                                    ?>
                                </div>
                            </div>
                        </div>
					</div>


                </div>
			</div> <!-- / scores area -->
        </div>
	</div>
    <div class="modal fade in" id="rec-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Recommendations and survey</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>My experience with BizTweak is:</label><br>
                            <label class="mr-1"><input name="exp" type="radio" value="1">1 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="2">2 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="3">3 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="4">4 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="5">5 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="6">6 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="7">7 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="8">8 </label>
                            <label class="mr-1"><input name="exp" type="radio" value="9">9 </label>
                            <label class="mr-1"><input name="exp" checked type="radio" value="10">10 </label>
                        </div>
                        <div class="form-group">
                            <label>Challenges I face in my business are:</label>
                            <input class="form-control" type="text" name="challenges_now" required>
                        </div>
                        <div class="form-group">
                            <label>The last time I faced this challenge was:</label>
                            <input class="form-control" type="text" name="challenges_before" required>
                        </div>
                        <div class="form-group">
                            <label>The solutions I used to try solve the challenge is:</label>
                            <input class="form-control" type="text" name="solutions_now" required>
                        </div>
                        <div class="form-group">
                            <label>What I didn’t like about the solution I tried is:</label>
                            <input class="form-control" type="text" name="solutions_before" required>
                        </div>
                        <h4>Recommendations:</h4>
                        <div class="form-group">
                            <label>Please select an option:</label>
                            <label><input checked value="Show me the topics I need to research I’ll, do it on my own." name="rec" type="radio"> Show me the topics I need to research I’ll, do it on my own.</label>
                            <label><input value="Willing to pay for learning content, resource documents, market research tools, competitor analysis tools and market segmentation tools that were created specifically to solve these gaps" name="rec" type="radio"> Willing to pay for learning content that was specifically created to solve these gaps.</label>
                        </div>
                        <div class="form-group d-none" id="price-field">
                            <label>For monthly  access and use of these resources and tools I am willing to pay</label>
                            <input type="number" min="1" max="9999" name="quote" class="form-control" value="">
                        </div>
                        <input type="hidden" name="user_id" value="<?= $logged_user_id ?>">
                        <input type="hidden" name="consultant_id" value="<?= $consultant_id ?>">
                        <div class="form-group">
                            <button class="px-2 btn btn-danger" type="submit" name="recommend">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade in" id="lms-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Learning Management System</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    Coming soon!
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="view-rec-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Report Recommendations</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p>The following are the topics and learning content you need to read and implement in order to improve the processes, systems in your business, as well as business performance</p>
                    <?php
                        $recs = [];
                        if($market_viability < 80){
                            if(!in_array('Market Intelligence',$recs)){
                                $recs[] = 'Market Intelligence';
                            }
                            if(!in_array('Strategic Planning',$recs)){
                                $recs[] = 'Strategic Planning';
                            }
                            if(!in_array('Financial Management',$recs)){
                                $recs[] = 'Financial Management';
                            }
                        }
                        if($biz_viability < 80){
                            if(!in_array('Financial Management',$recs)){
                                $recs[] = 'Financial Management';
                            }
                            if(!in_array('Marketing & Sales',$recs)){
                                $recs[] = 'Marketing & Sales';
                            }
                            if(!in_array('Product development',$recs)){
                                $recs[] = 'Product development';
                            }
                        }
                        if($biz_scalability < 80){
                            if(!in_array('Market Intelligence',$recs)){
                                $recs[] = 'Market Intelligence';
                            }
                            if(!in_array('Marketing & Sales',$recs)){
                                $recs[] = 'Marketing & Sales';
                            }
                            if(!in_array('Talent Management',$recs)){
                                $recs[] = 'Talent Management';
                            }
                            if(!in_array('Product development',$recs)){
                                $recs[] = 'Product development';
                            }
                        }
                        if($investor_readines < 80){
                            if(!in_array('Business Process Management',$recs)){
                                $recs[] = 'Business Process Management';
                            }
                            if(!in_array('Marketing & Sales',$recs)){
                                $recs[] = 'Marketing & Sales';
                            }
                            if(!in_array('Talent Management',$recs)){
                                $recs[] = 'Talent Management';
                            }
                            if(!in_array('Strategic Planning',$recs)){
                                $recs[] = 'Strategic Planning';
                            }
                            if(!in_array('Product development',$recs)){
                                $recs[] = 'Product development';
                            }
                            if(!in_array('Market Intelligence',$recs)){
                                $recs[] = 'Market Intelligence';
                            }
                            if(!in_array('Financial Management',$recs)){
                                $recs[] = 'Financial Management';
                            }
                            if(!in_array('Legal',$recs)){
                                $recs[] = 'Legal';
                            }
                        }
                        if($customer_and_revenue < 80){
                            if(!in_array('Business Process Management',$recs)){
                                $recs[] = 'Business Process Management';
                            }
                            if(!in_array('Marketing & Sales',$recs)){
                                $recs[] = 'Marketing & Sales';
                            }
                            if(!in_array('Talent Management',$recs)){
                                $recs[] = 'Talent Management';
                            }
                            if(!in_array('Strategic Planning',$recs)){
                                $recs[] = 'Strategic Planning';
                            }
                        }
                        if($finance < 80){
                            if(!in_array('Business Process Management',$recs)){
                                $recs[] = 'Business Process Management';
                            }
                            if(!in_array('Talent Management',$recs)){
                                $recs[] = 'Talent Management';
                            }
                        }
                        if($emp_performance < 80){
                            if(!in_array('Strategic Planning',$recs)){
                                $recs[] = 'Strategic Planning';
                            }
                            if(!in_array('Product development',$recs)){
                                $recs[] = 'Product development';
                            }
                        }
                        $rec_description = [
                            'Business Process Management' => 'Processes, Documentation and Systems you need to have in place in order to measure, analyze and improve your business.',
                            'Marketing & Sales' => 'Plans, resources and tools that need to be used to position your business and encourage your target audience to buy.',
                            'Talent Management' => 'Processes, procedures and characteristics that need to be applied in order to manage employee and employer relationships.',
                            'Strategic Planning' => 'Plans that need to be designed, developed and executed in order for the business to be attractive, viable and to grow.',
                            'Product development' => 'Tools that can be used to sell your product/service online to a wider audience.',
                            'Market Intelligence' => 'Areas of your business you need to fulfil in order to understand, anticipate and/influence the needs of your target customers and their environment.',
                            'Financial Management' => 'Areas of your revenue model that need to be managed in order to improve the financial health of your business.',
                            'Legal' => 'The areas of your business that you are required to know of so that you stay compliant and knowledgeable about your enviroment.'
                        ];
                        ?>
                        <div >
                        <?php
                        $i = 0;
                        foreach ($recs as $key => $rec):
                            $i++;
                            ?>
                            <div data-toggle="collapse" data-target="#recommend-<?= $i ?>" style="cursor:pointer;">
                                <b><?= $rec ?> <i class="fa fa-caret-down"></i></b>
                                <p><?= $rec_description[$rec] ?></p>
                            </div>
                            <div id="recommend-<?= $i ?>" class="collapse mb-2">
                            <?php foreach ($recommendations_data[$rec] as $key => $value): ?>
                                <p class="mb-0 list-group-item"><?= $value ?></p>
                            <?php endforeach;?>
                        </div>
                        <?php endforeach; ?>
                        <?php if(count($recs) < 1): ?>
                        <li class="list-group-item">All good, No recommendations!</li>
                        <?php endif; ?>
                        </div>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?help=1" class="my-2 btn btn-primary px-2">Help me with this</a>
                </div>

            </div>
        </div>
    </div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script type="text/javascript">
        $("[name='rec']").on('change', (e)=>{
            $("#price-field").toggleClass('d-none');
            if($(e.target).val() != 'Show me the topics I need to research I’ll, do it on my own.'){
                $("#price-field input").attr('required','required');
            }else{
                $("#price-field input").removeAttr('required');
            }
        });
    </script>
</body>
</html>
