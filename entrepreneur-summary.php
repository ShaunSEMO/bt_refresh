<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include 'includes/header.php';
$user_scores = array();
$user_id = $logged_user_id;
$user_name = $user_info->name;
$user_info = $logged_user->user_info($logged_user_id);
$choice = $user_info->choice;
global $scores;
$user_scores = $scores->score_q($user_id);
$total_avg = 0;
foreach ($user_scores as $key => $score) {
    if ($score['average'] !== 'NAN') {
        $total_avg += $score['average'];
    }
}
$biz_rating = ($total_avg / (count($user_scores) * 100)) * 100;
$market_viability = $biz_viability = $biz_scalability = $investor_readines = $customer_and_revenue = $finance = $emp_performance = 0;


$data = [
    'market_viability' => [],
    'biz_viability' => [],
    'biz_scalability' => [],
    'investor_readiness' => [],
    'customer_and_revenue' => [],
    'finance' => [],
    'emp_performance' => []
];

$desc = [
    'market_viability' => 'Take this assessment if you want to test the market readiness of your business.',
    'biz_viability' => 'Take this assessment if you want to know if your business idea can work.',
    'biz_scalability' => 'Take this assessment if you want to test what your business needs to scale.',
    'investor_readiness' => 'Take this assessment to find out what you need to get your business investor ready.',
    'customer_and_revenue' => 'Take this assessment to find out how customer focused your business is.',
    'finance' => 'Take this assessment to measure how you are doing in managing your finances.',
    'emp_performance' => 'take this assessment to test the quality of employee systems you have.'
];

$mapping = [
    'Understand-Find my target market' => 'market_viability',
    'Test my business idea' => 'biz_viability',
    'Know if I can scale my business' => 'biz_scalability',
    'Get my business investor ready' => 'investor_readiness',
    'Get customers & revenue' => 'customer_and_revenue',
    'Start a business' => 'finance',
    'Improve my employee performance' => 'emp_performance',
];

$market_viability_data = $biz_viability_data = $biz_scalability_data = $investor_readines_data = $customer_and_revenue_data = $finance_data = $emp_performance_data  = [];

foreach ($questions_seq as $major_key => $major_cat) {
    $total_q = 0;
    $q_answered = 0;
    foreach ($major_cat as $cat_key => $cat) {
        $questions = $assessment->all_quesion_ids_by_cat($cat);
        $total_q += count($questions);
        foreach($questions as $q){
            $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$logged_user_id'";
            if($db->query($query)->num_rows > 0){
                $q_answered++;
            }
        }
    }
    $type = $mapping[$major_key];
    $data[$type] = round(($q_answered/$total_q) * 100, 2);
}

foreach ($questions_seq as $key => $sets) {
    $key_check = strtolower($key);
    $search_array = array_map('strtolower', $sets);
    $search_array = array_map('trim', $search_array);
    foreach ($user_scores as $k => $score) {
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Understand-Find my target market')) {
            $market_viability += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Test my business idea')) {
            $biz_viability += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Know if I can scale my business')) {
            $biz_scalability += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Get my business investor ready')) {
            $investor_readines += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Get customers & revenue')) {
            $customer_and_revenue += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Start a business')) {
            $finance += $score['average'];
        }
        if (in_array(strtolower($score['type']), $search_array) and $key_check == strtolower('Improve my employee performance')) {
            $emp_performance += $score['average'];
        }

    }
}


$market_viability = $market_viability / count($questions_seq['Understand-Find my target market']);
$biz_viability = $biz_viability / count($questions_seq['Test my business idea']);
$biz_scalability = $biz_scalability / count($questions_seq['Know if I can scale my business']);
$investor_readines = $investor_readines / count($questions_seq['Get my business investor ready']);
$customer_and_revenue = $customer_and_revenue / count($questions_seq['Get customers & revenue']);
$finance = $finance / count($questions_seq['Start a business']);
$emp_performance = $emp_performance / count($questions_seq['Improve my employee performance']);
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
$colors = ['#585', '#345', '#356', '#934', '#249', '#204', '#294', '#960'];
$new_scores = [];
foreach ($questions_seq as $key => $sets) {
    $search_array = array_map('strtolower', $sets);
    $search_array = array_map('trim', $search_array);
    foreach ($user_scores as $k => $score) {
        if (in_array(strtolower($score['type']), $search_array)) {
            $new_scores[$key][] = $score;
        }
    }
}

if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    $query = "UPDATE users SET choice='$choice' WHERE user_id='$logged_user_id'";
    $db->query($query);
    header("Location: entrepreneur.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Biz Tweak | Scores</title>
    <!-- Meta tags -->
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all"/>
    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/font-awesome.css"/>
    <!-- font-awesome-icons -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <!-- bootstrap V4.5.0 -->
    <script>
        window.onload = function () {
            <?php
            $missed = [];
            $i = 0;
            foreach ($percentages as $key => $percentage) {
                $match = str_replace("&","and",str_replace(" ","_",strtolower($key)));
                if($match != 'biz_rating'){
                    if($data[$match] < 100){$missed[] = $key; continue;}
                }
                 $i++;?>
            var chart_<?= $i ?> = new CanvasJS.Chart("chartContainer_<?= $i ?>", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: 'rgba(0, 0, 0, 0)',
                title: {
                    text: "<?= $key ?>"
                },
                legend: {
                    fontFamily: "calibri",
                    fontSize: 14,
                    itemTextFormatter: function (e) {
                        return "<?= $key ?>" + ": " + Math.round(<?= $percentage ?>) + "%";
                    }
                },
                data: [{
                    cursor: "pointer",
                    showInLegend: true,
                    startAngle: 90,
                    type: "doughnut",
                    dataPoints: [
                        {y: <?= round($percentage) ?>, name: "<?= $key ?> (%)", color: "<?= $colors[$i] ?>"},
                    ]
                }],
            });
            chart_<?= $i ?>.render();
            <?php } ?>

            var chart = new CanvasJS.Chart("chartContainerConcept", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: 'rgba(0, 0, 0, 0)',
                title: {
                    text: "Business Concept",
                    fontSize: 14
                },
                axisY: {
                    title: "Scores Average (%)",
                    fontSize: 12
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Business Concept Scores Average",
                    dataPoints: [
                        {y: <?= empty($user_scores[0]['average'])?0:$user_scores[0]['average']; ?>, label: " "},
                        {y: <?= empty($user_scores[1]['average'])?0:$user_scores[1]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[2]['average'])?0:$user_scores[2]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[3]['average'])?0:$user_scores[3]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[4]['average'])?0:$user_scores[4]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[5]['average'])?0:$user_scores[5]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[6]['average'])?0:$user_scores[6]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[7]['average'])?0:$user_scores[7]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[8]['average'])?0:$user_scores[8]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[9]['average'])?0:$user_scores[9]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[10]['average'])?0:$user_scores[10]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[11]['average'])?0:$user_scores[11]['average']; ?>, label: " "}
                    ]
                }]
            });
            chart.render();

            var chart = new CanvasJS.Chart("chartContainerStructure", {
                animationEnabled: true,
                backgroundColor: 'rgba(0, 0, 0, 0)',
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Business Structure",
                    fontSize: 14
                },
                axisY: {
                    title: "Scores Average (%)",
                    fontSize: 12
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Business Structure Scores Average",
                    dataPoints: [
                        {y: <?= empty($user_scores[11]['average'])?0:$user_scores[11]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[12]['average'])?0:$user_scores[12]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[13]['average'])?0:$user_scores[13]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[14]['average'])?0:$user_scores[14]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[15]['average'])?0:$user_scores[15]['average']; ?>, label: ""},
                        {y: <?= empty($user_scores[16]['average'])?0:$user_scores[16]['average']; ?>, label: ""}
                    ]
                }]
            });
            chart.render();
        };
    </script>
    <style media="screen">
        .h-200 {
            height: 150px;
        }

        .h-300 {
            height: 250px;
        }
    </style>
</head>
<body style="background: #edf5e1;">
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
                <a class="nav-link" href="signed-out.php"> <i class="fa fa-sign-out" aria-hidden="true"></i> Sign out
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
                <a class="btn btn-warning" href="entrepreneur-scores.php"><i class="fa fa-file"></i> See Full Report</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <?php
                $i = 0;
                foreach ($percentages as $key => $percentage) {
                    $match = str_replace("&","and",str_replace(" ","_",strtolower($key)));
                    if($match != 'biz_rating'){
                        if($data[$match] < 100){continue;}
                    }
                    $i++; ?>
                    <div class="col-md-3 mb-5 text-center">
                        <div class="h-200" id="chartContainer_<?= $i ?>"></div>
                    </div>
                <?php } ?>
                <?php foreach ($missed as $key => $miss):
                    $match = str_replace("&","and",str_replace(" ","_",strtolower($miss)));
                    ?>
                    <div class="col-md-3 mb-5 text-center bg-warning pt-1">
                        <div class="h-200">
                            <p class="mb-1 small font-weight-bold"><?= $miss ?> <br> (<?= round($data[$match]) ?>% completed)</p>
                            <p class="small mb-1"><?= $desc[$match] ?></p>
                            <?php foreach ($mapping as $choice => $cat): ?>
                                <?php if ($cat == $match): ?>
                                    <a href="<?= $_SERVER['PHP_SELF'] ?>?choice=<?= $choice ?>" style="line-height:1;" class="btn btn-sm p-2 btn-info">Take Assessment</a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="h-300" id="chartContainerStructure"></div>
                </div>
                <div class="col-md-6">
                    <div class="h-300" id="chartContainerConcept"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>
</html>
