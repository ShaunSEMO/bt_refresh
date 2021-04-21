<?php
    session_start();
    require_once "class_database.php";
    include 'class_user.php';
    include 'class_assessments.php';

    $assessment = new assessments;
    $db = new database;
    $logged_user = new user;
    $user_id = $logged_user->get_logged_user_id();
    $alert = array();

    if (!empty($_POST)){
        $form_type = $_POST["form_type"];

        // save biz info responses
        if ($form_type == 'save-biz-info'){
            $name = $_POST['name'];
            $number = $_POST['number'];
            $address = $_POST['address'];
            $date = $_POST['date'];
            $bio = $_POST['bio'];
            $phase = $_POST['phase'];
            $industry = $_POST['industry'];
            $offering = $_POST['offering'];
            $turnover = $_POST['turnover'];
            $employees = $_POST['employees'];
            $logged_user->save_biz_info($user_id, $name, $number, $date, $address, $bio, $phase, $industry, $offering, $turnover, $employees);
        }

        // save question responses
        if ($form_type == 'save-responses'){
            $question_id = $_POST['question_id'];
            $yes_answer = $_POST['yes_answer'];
            $no_answer = $_POST['no_answer'];

            echo $question_id;
            // check if the questions are not already answered
            $question_exist = $assessment->is_question_answered($user_id, $question_id);
            if ($question_exist < 1) {
                // saving answers to the database
                $assessment->save_questions($user_id, $question_id, $yes_answer, $no_answer);
            }else{
                $a_id = $question_exist->id;
                $db->query("UPDATE q_answers SET yes_answer='$yes_answer', no_answer='$no_answer' WHERE id='$a_id'");
            }
        }

        // save profile information
        if ($form_type == 'save-profile'){
            // getting all the values from the form
            $name = $_POST['name'];
            $designation = $_POST['designation'];
            $location = $_POST['location'];
            $education = $_POST['education'];
            $status = $_POST['status'];
            $type = $_POST['type'];
            $stage = $_POST['stage'];
            $bio = $_POST['bio'];
            $choice = $_POST['choice'];
            $offering = $_POST['offering'];

            // saving information
            if ($logged_user->save_profile_info($user_id, $name, $designation, $location, $education, $status, $type, $stage, $bio, $choice, $offering) === TRUE){
                echo '<div id="alert" class="alert alert-success" role="alert">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> Infomation Saved!
                </div>';
            }

        }

        // updating question responses
        if ($form_type == 'question-responses'){
            echo 'working so far';
        }
    }
?>
