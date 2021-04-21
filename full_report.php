<?php 
	include 'includes/header.php';
    global $scores;
    $user_scores = $scores->score_q(16);
?>
<!doctype html>
<html>

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
    <script src="js/Chart.bundle.js"></script>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
</head>

<body style="background: #EDF5E1">
    <!--Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark info-color">
	  <a class="navbar-brand" href="#">Biztweak | Consultant Dashboard</a>
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
				<div class="followers-box">
					<?php $logged_user->display_followers($logged_user_id); ?>
				</div>
			</div>
			<div class="col-9">
                <h4>Business Concept</h4>
                <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                <p><?php echo $user_scores[0]['type'].' | score : '.$user_scores[0]['score'].' average: '.$user_scores[0]['average'].'%'?></p>
                <p><?php echo $user_scores[1]['type'].' | score : '.$user_scores[1]['score'].' average: '.$user_scores[1]['average'].'%'?></p>
                <p><?php echo $user_scores[2]['type'].' | score : '.$user_scores[2]['score'].' average: '.$user_scores[2]['average'].'%'?></p>
                <p><?php echo $user_scores[3]['type'].' | score : '.$user_scores[3]['score'].' average: '.$user_scores[3]['average'].'%'?></p>
                <p><?php echo $user_scores[4]['type'].' | score : '.$user_scores[4]['score'].' average: '.$user_scores[4]['average'].'%'?></p>
                <p><?php echo $user_scores[5]['type'].' | score : '.$user_scores[5]['score'].' average: '.$user_scores[5]['average'].'%'?></p>
                <p><?php echo $user_scores[6]['type'].' | score : '.$user_scores[6]['score'].' average: '.$user_scores[6]['average'].'%'?></p>
                <p><?php echo $user_scores[7]['type'].' | score : '.$user_scores[7]['score'].' average: '.$user_scores[7]['average'].'%'?></p>
                <p><?php echo $user_scores[8]['type'].' | score : '.$user_scores[8]['score'].' average: '.$user_scores[8]['average'].'%'?></p>
                <p><?php echo $user_scores[9]['type'].' | score : '.$user_scores[9]['score'].' average: '.$user_scores[9]['average'].'%'?></p>
                <p><?php echo $user_scores[10]['type'].' | score : '.$user_scores[10]['score'].' average: '.$user_scores[10]['average'].'%'?></p>
                <div id="canvas-holder" style="width:75%">
                    <canvas id="chart-area"></canvas>
                </div>
                <h4>Business Structure</h4>
                <p><?php echo $user_scores[11]['type'].' | score : '.$user_scores[11]['score'].' average: '.$user_scores[11]['average'].'%'?></p>
                <p><?php echo $user_scores[12]['type'].' | score : '.$user_scores[12]['score'].' average: '.$user_scores[12]['average'].'%'?></p>
                <p><?php echo $user_scores[13]['type'].' | score : '.$user_scores[13]['score'].' average: '.$user_scores[13]['average'].'%'?></p>
                <p><?php echo $user_scores[14]['type'].' | score : '.$user_scores[14]['score'].' average: '.$user_scores[14]['average'].'%'?></p>
                <p><?php echo $user_scores[15]['type'].' | score : '.$user_scores[15]['score'].' average: '.$user_scores[15]['average'].'%'?></p>
                <p><?php echo $user_scores[16]['type'].' | score : '.$user_scores[16]['score'].' average: '.$user_scores[16]['average'].'%'?></p>         
                
            </div>
    <script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
    var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
    };
    var randomColor = function(opacity) {
        return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                    "#4D5360",
                ],
                label: 'Dataset 1'
            }, {
                hidden: true,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                    "#4D5360",
                ],
                label: 'Dataset 2'
            }, {
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                    "#4D5360",
                ],
                label: 'Dataset 3'
            }],
            labels: [
                "<?php echo $user_scores[0]['type']; ?>",
                "<?php echo $user_scores[1]['type']; ?>",
                "<?php echo $user_scores[2]['type']; ?>",
                "<?php echo $user_scores[3]['type']; ?>",
                "<?php echo $user_scores[4]['type']; ?>"
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Business Concept'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myDoughnut = new Chart(ctx, config);
    };

    $('#randomizeData').click(function() {
        $.each(config.data.datasets, function(i, dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });

            dataset.backgroundColor = dataset.backgroundColor.map(function() {
                return randomColor(0.7);
            });
        });

        window.myDoughnut.update();
    });

    $('#addDataset').click(function() {
        var newDataset = {
            backgroundColor: [],
            data: [],
            label: 'New dataset ' + config.data.datasets.length,
        };

        for (var index = 0; index < config.data.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());
            newDataset.backgroundColor.push(randomColor(0.7));
        }

        config.data.datasets.push(newDataset);
        window.myDoughnut.update();
    });

    $('#addData').click(function() {
        if (config.data.datasets.length > 0) {
            config.data.labels.push('data #' + config.data.labels.length);

            $.each(config.data.datasets, function(index, dataset) {
                dataset.data.push(randomScalingFactor());
                dataset.backgroundColor.push(randomColor(0.7));
            });

            window.myDoughnut.update();
        }
    });

    $('#removeDataset').click(function() {
        config.data.datasets.splice(0, 1);
        window.myDoughnut.update();
    });

    $('#removeData').click(function() {
        config.data.labels.splice(-1, 1); // remove the label first

        config.data.datasets.forEach(function(dataset, datasetIndex) {
            dataset.data.pop();
            dataset.backgroundColor.pop();
        });

        window.myDoughnut.update();
    });
    </script>
</body>

</html>
