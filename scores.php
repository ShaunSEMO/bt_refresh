<?php
    include 'includes/header.php';
    $user_scores = array();

    $user_id = $_POST['user_id'];
    $user_name = $_POST['name'];

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//$('body').on('click', '.completed-user', function(e) {
			//var box = $(this);
			//var user_id = $(this).find('#user_id').val()
			//alert(user_id);
			//$("#scores-area").load("report.php", {user_ID: user_id});
		//});

		//$("#completed-user").click(function(){
			//var userId = document.getElementById('user_id').value;
			//alert(userId);
			// $("#scores-area").load("report.php #completed-user");
		//});
	});
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
            <div class="col-md-3">
                <div class="admin-box">
                    <i id="user-img" class="fa fa-user" aria-hidden="true"></i>
                    <h2><?php echo $user_info->name; ?></h2>
                    <p>Consultant</p>
                    <hr class="divider">
                    <h6><span class="badge badge-secondary"><?php echo $logged_user->num_followers($logged_user_id); ?></span> Entrepreneurs</h6>
                </div>
                <div class="completed-assess-box">
                    <p>Completed Assessments</p>
                    <hr class="divider">
                    <?php $assessment->display_complete_box($logged_user_id); ?>
                </div>
            </div>
            <div class="col-md-9">
				<h4> Business Concept <span class="badge badge-secondary"> <?php echo $user_name; ?></span></h4>
				<!-- scores area -->
				<div id="scores-area">
					<div id="chartContainerConcept" style="height: 300px; width: 100%;"></div>
					<div class="priority-elements-box">
						<div>
                            <h4 data-toggle="collapse" data-target="#priority-1" class="collapsed float-left">Priority Elements</h4>
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
                              <?php
                                  if (!empty($incomp)) {
                                      echo '</div>';
                                  }
                               ?>
                        </div>
					</div>

                     <!-- Highest performing Areas-->
					<div class="priority-elements-box">
						<h4 data-toggle="collapse" data-target="#high-1" class="collapsed">High Performing Area</h4>
                        <div class="collapse" id="high-1">
                            <?php $scores->display_high_top3($user_id, 'concept'); ?>
                        </div>
					</div>

					<!-- Major gaps -->
					<div class="priority-elements-box">
                        <h4 data-toggle="collapse" data-target="#major-1" class="collapsed">Major Gaps</h4>
                        <div class="collapse" id="major-1">
                            <?php $scores->display_low_top3($user_id, 'concept'); ?>
                        </div>
					</div>

                    <div class="priority-elements-box">
                        <h4 data-toggle="collapse" data-target="#other-1" class="collapsed">Other Assessments</h4>
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

					<h4>Business Structure <span class="badge badge-secondary"> <?php echo $user_name; ?></span></h4>
					<div id="chartContainerStructure" style="height: 300px; width: 100%;"></div>
                    <div class="priority-elements-box">
						<h4 data-toggle="collapse" data-target="#priority-2" class="collapsed">Priority Elements</h4>
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
                              <?php
                                  if (!empty($incomp)) {
                                      echo '</div>';
                                  }
                               ?>
                        </div>
					</div>
					<!-- Highest performing Areas-->
					<div class="priority-elements-box">
						<h4 data-toggle="collapse" data-target="#high-2" class="collapsed">High Performing Area</h4>
                        <div class="collapse" id="high-2">
                            <?php $scores->display_high_top3($user_id, 'structure'); ?>
                        </div>
					</div>

					<!-- Major gaps -->
					<div class="priority-elements-box">
						<h4 data-toggle="collapse" data-target="#major-2" class="collapsed">Major Gaps</h4>
                        <div class="collapse" id="major-2">
                            <?php $scores->display_low_top3($user_id, 'structure'); ?>
                        </div>
					</div>
                    <div class="priority-elements-box">
                        <h4 data-toggle="collapse" data-target="#other-2" class="collapsed">Other Assessments</h4>
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
			</div> <!-- / scores area -->
        </div>
	</div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>
</html>
