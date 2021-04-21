<?php 
	include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak | Consultant </title>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- //Meta tags -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
    <link href="css/font-awesome.css" rel="stylesheet"><!-- font-awesome-icons -->
	<link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap V4.5.0 -->
	<script src="js/Chart.bundle.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // showing and hiding tables
            $('#concept_btn').click(function () {
                $('#concept-table').show();
                $('#structure-table').hide();
            });
            $('#structure_btn').click(function () {
                $('#structure-table').show();
                $('#concept-table').hide();
            });

            $('[data-toggle="tooltip"]').tooltip();
            var actions = $("table td:last-child").html();

            // Append table with add row form on add new button click
            $(".add-new").click(function(){
                $(this).attr("disabled", "disabled");
                var index = $("table tbody tr:first-child").index();
                var row = '<tr>' +
                    '<td><input type="text" class="form-control" name="name" id="name"></td>' +
                    '<td><input type="text" class="form-control" name="department" id="department"></td>' +
                    '<td>' + actions + '</td>' +
                    '</tr>';
                $("table").prepend(row);
                $("table tbody tr").eq(index).find(".add, .edit").toggle();
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Add row on add button click
            $(document).on("click", ".add", function(){
                var empty = false;
                var input = $(this).parents("tr").find('input[type="text"]');
                input.each(function(){
                    if(!$(this).val()){
                        $(this).addClass("error");
                        empty = true;
                    } else{
                        $(this).removeClass("error");
                    }
                });
                $(this).parents("tr").find(".error").first().focus();
                if(!empty){
                    input.each(function(){
                        $(this).parent("td").html($(this).val());
                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                }
            });

            // Edit row on edit button click
            $(document).on("click", ".edit", function(){
                //var question_id = $(this).parents("tr").find("#question_id").val();
                //var question_category = $(this).parents("tr").find("#question-category").text();
                //var question_text = $(this).parents("tr").find("#question-text").text();

                $(this).parents("tr").find("td:not(:last-child)").each(function(){
                    $(this).html('<input id="question_id" type="text" class="form-control" value="' + $(this).text() + '">');
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");
            });

            // Delete row on delete button click
            $(document).on("click", ".delete", function(){
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
            });
        });
    </script>
</head>

<body style="background: #EDF5E1">
	<!--Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark info-color">
	  <a class="navbar-brand" href="consultant.php">Biztweak | Consultant Dashboard</a>
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
                <button class="review-questions-btn title-text">
                    <a href="consultant.php">
                        <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                            Review Assessments
                    </a>
                </button>
                <button class="edit-questions-btn title-text">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Review Questions
                </button>
				<hr class="divider">
                <div class="clear"></div>

                <button id="concept_btn">Concept Question</button>
                <button id="structure_btn">Structure Question</button>

                <!-- all concept questions section -->
                <table id="concept-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="color: #4e555b; font-size: large;">Category</th>
                        <th style="color: #4e555b; font-size: large;"><span class="badge badge-secondary">concept</span> Questions</th>
                        <th><button type="button" class="add-new"><i class="fa fa-plus"></i> Add New</button></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($assessment->load_concept_questions() as $val) { ?>
                    <tr>
                        <input id="question_id" type="hidden" name="question_id" value="<?php echo $val->question_id; ?>">
                        <td id="question-category"><?php echo $val->sub_category; ?></td>
                        <td id="question-text"><?php echo $val->question_text; ?></td>
                        <td>
                            <a class="add" title="Add" data-toggle="tooltip"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>

                <!-- all structure questions section -->
                <table id="structure-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="color: #4e555b; font-size: large;">Category</th>
                        <th style="color: #4e555b; font-size: large;"><span class="badge badge-secondary">structure</span> Questions</th>
                        <th><button type="button" class="add-new"><i class="fa fa-plus"></i> Add New</button></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($assessment->load_structure_questions() as $val) { ?>
                        <tr>
                            <td><?php echo $val->sub_category; ?></td>
                            <td><?php echo $val->question_text; ?></td>
                            <td>
                                <a class="add" title="Add" data-toggle="tooltip"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>

                <!-- all questions section --
				<div class="all-questions-box">
					<h5>Business Concept Questions</h5>
					<form>
					<table>
					  <tr>
						<th>Category</th>
						<th>Question</th>
						<td><button> Add New </button></td>
					  </tr>
					  <?php //$assessment->load_concept_questions(); ?>
					</table>
					</form>

				</div> /all questions section -->

				<!-- all questions section
				<div class="all-questions-box">
					<h5>Business Structure Questions</h5>
					<form>
					<table>
					  <tr>
						<th>Category</th>
						<th>Question</th>
					  </tr>
					  <?php //$assessment->load_structure_questions(); ?>
					</table>
					</form>
				</div><! /all questions section -->

			</div>
		</div>
	</div>
	<nav class="navbar fixed-bottom navbar-light bg-light">
  		<a class="navbar-brand" href="#">© 2020 Biz Tweak. All rights reserved</a>
	</nav>
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/style.js"></script>
</body>
</html>