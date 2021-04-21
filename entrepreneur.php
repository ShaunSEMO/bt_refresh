<?php
   // start of sessions
   session_start();
   // echo '<pre>';
   // print_r($_SESSION);
   // exit;
   // Error Reporting
   error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
   
   // database initiation
   require_once 'includes/class_database.php';
   include 'includes/class_user.php';
   include 'includes/class_assessments.php';
   $db = new database;
   $logged_user = new user;
   $assessment = new assessments;
   $questions_seq = [
       'Test my business idea' => [
           'Value proposition',
           'functional capability',
           'Customer segments',
           'Proof of concept',
           'delivery and expertise',
           'market intelligence',
           'Revenue streams',
           'Key activities',
           'Key resources',
           'Cost structure'],
       'Get customers & revenue' => ['Customer relationships',
           'Channels',
           'e-commerce',
           'functional capability',
           'Customer segments',
           'Business and customers',
           'Marketing and sales',
           'Revenue streams'
       ],
       'Understand-Find my target market' => ['market intelligence',
           'delivery and expertise',
           'e-commerce',
           'Business and customers',
           'Ownership and mindset',
           'Marketing and sales',
           'Value proposition',
           'Key activities',
           'Customer segments'],
       'Get my business investor ready' => ['Value proposition'
           , 'Customer segments',
           'functional capability',
           'compliance and certification',
           'legal',
           'commercial contracts agreements',
           'Proof of concept',
           'Channels',
           'Revenue streams',
           'Cost structure',
           'Unique selling point',
           'Ownership and mindset',
           'Business and customers',
           'Growth strategy',
           'Financial management'],
       'Know if I can scale my business' => ['Current alternatives',
           'Channels',
           'Key partners',
           'Cost structure',
           'Customer relationships',
           'Business process management',
           'Marketing and sales',
           'Employee satisfaction',
           'Growth strategy',
           'delivery and expertise',
           'market intelligence',
           'Financial management'],
       'Improve my employee performance' => ['Business process management',
           'Ownership and mindset',
           'Employee satisfaction'],
       'Start a business' => ['Value proposition',
           'functional capability',
           'customer segments',
           'Proof of concept']
   ];
   $logged_user_id = $logged_user->get_logged_user_id();
   $logged_user_type = $logged_user->get_logged_user_type();
   $business_info = $logged_user->business_info($logged_user_id);
   $user_info = $logged_user->user_info($logged_user_id);
   $followers = $logged_user->followers($logged_user_id);
   
   $major_cat = $questions_seq[$user_info->choice];
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
   $assessment_completed = round(($q_answered/$total_q) * 100, 2);
   
   if (isset($_POST['update-info'])) {
       $choice = $_POST['choice'];
       $query = "UPDATE users SET choice='$choice' WHERE user_id='$logged_user_id'";
       $db->query($query);
   }
   
   //Check whether the session variables are present or not
   if ((!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) &&
       (!isset($_SESSION['SESS_TYPE']) || (trim($_SESSION['SESS_TYPE']) == ''))) {
       header("location: access-denied.php");
       exit();
   }
   
   //include 'includes/header.php';
   $progress_per = $assessment->progress_bar($logged_user_id);
   
   ?>
<!DOCTYPE html>
<html lang="zxx">
   <head>
      <title>Biz Tweak | Entrepreneur</title>
      <link rel="icon" href="images/logo_short.png">
      <!-- Meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <!-- //Meta tags -->
      <link rel="stylesheet" href="css/style.css" type="text/css" media="all"/>
      <!-- Style-CSS -->
      <link rel="stylesheet" href="css/font-awesome.css" rel="stylesheet">
      <!-- font-awesome-icons -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- bootstrap V4.5.0 -->
      <style>
         input[type="checkbox"] {
         -webkit-appearance: checkbox;
         }
         input[type="radio"] {
         -webkit-appearance: radio;
         }
         .progress {
         margin: 10px 0;
         border: 3px solid #FFFFFF;
         border-radius: 10px;
         / / box-shadow: 0 4 px 8 px 0 rgba(0, 0, 0, 0.2);
         }
         .progress-bar {
         font-size: large;
         text-shadow: 2px 2px 5px #3b5998;
         background-color: <?php echo $progress_per['color']; ?>;
         width: <?php echo $progress_per['score']; ?>%;
         }
         table td {
         width: 80%;
         }
         .alert {
         font-size: large;
         padding: 2px;
         margin: 5px 0;
         width: 90%;
         }
         #save-alert {
         display: none;
         }
         #info-modal .modal-dialog {
         position: absolute;
         left: 50%;
         top: 50%;
         transform: translate(-50%, -50%);
         width: 500px;
         max-width: 100%;
         }

         /* * {
             border: 1px solid red;
         } */
         
      </style>
   </head>
   <body style="background: #EDF5E1">
      <nav class="navbar navbar-expand-lg navbar-dark info-color">
         <a class="navbar-brand" href="#">Biztweak | Entrepreneur Dashboard</a>
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
                  <hr class="divider">
                  <h6><?php echo $business_info->name; ?></h6>
               </div>
            </div>
            <div class="col-md-9">
               <div class="title-text">Check you progress;</div>
               <!-- progress bar-->
               <div id="progress" class="progress" style="height: 50px;">
                  <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                     <?php echo $progress_per['score']; ?>% completed
                  </div>
               </div>
               <!-- /progress bar-->
               <?php
                  if (empty($business_info->name) || empty($business_info->number) || empty($business_info->date) || empty($business_info->address) || empty($business_info->stage) || empty($business_info->industry) || empty($business_info->offering) || empty($business_info->turnover) || empty($business_info->employees)) {
                      $incomplete = true;
                  }else {
                      $incomplete = false;
                  }
                  ?>
               <div id="biz-info-btn" class="<?= ($assessment_completed < 100 AND $incomplete)?'glow':''; ?> questions-box-1">
                  <h2>Biz Info</h2>
                  <!-- <span class="badge badge-pill badge-info">2/10</span> Completed Questions -->
               </div>
               <div id="biz-concept-btn" class="<?= ($assessment_completed < 100 AND !$incomplete)?'glow':''; ?> questions-box-3">
                  <h2>Biz Assessment</h2>
                  <!-- <span class="badge badge-pill badge-info">2/10</span> Completed Questions -->
               </div>
               <!-- <div id="biz-structure-btn" class="questions-box-2">
                  <h2>Biz Structure</h2>
                  <span class="badge badge-pill badge-info">2/10</span> Completed Questions
                  </div> -->
               <div class="clear"></div>
               <!-- alert bar -->
               <div id="save-alert" class="alert alert-success" role="alert">
                  <i class="fa fa-check-square" aria-hidden="true"></i> Business Information saved successfully!
               </div>










               <!-- business information section-->
               <div class="biz-info-area">
                  <form id="profile-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                     <input type="hidden" name="form_type" value="save-biz-info"/>
                     <p>
                        <span>Enterprise Name</span>
                        <input type="text" name="name" value="<?php echo $business_info->name; ?>"/>
                     </p>
                    <br>
                     <p>
                        <span>Enterprise Number</span>
                        <input type="number" name="number" value="<?php echo $business_info->number; ?>"/>
                    </p>
                    <br>
                     <p>
                        <span>Registration Date</span>
                        <input type="date" name="date" value="<?php echo $business_info->date; ?>"/>
                     </p>
                    <br>
                     <p>
                        <span>Enterprise Address</span>
                        <input id="autocomplete" type="text" name="address" value="<?php echo $business_info->address; ?>"/>
                    </p>
                    <br>
                     <input type="hidden" name="bio" value="<?php echo $business_info->bio; ?>"/>

                     <p>
                        <label for="phase">Business Phase</label>
                        <select id="phase" name="phase">
                           <option> select >></option>
                           <option <?= $business_info->stage == 'idea'?'selected':''; ?> value="idea"> Idea/Concept</option>
                           <option <?= $business_info->stage == 'pre-revenue'?'selected':''; ?> value="pre-revenue"> Start Up (Pre-revenue)</option>
                           <option <?= $business_info->stage == 'post-revenue'?'selected':''; ?> value="post-revenue"> Start Up (Post-revenue)</option>
                           <option <?= $business_info->stage == 'established'?'selected':''; ?> value="established"> Established Enterprise (&gt; 2 years)</option>
                        </select>
                     </p>
                    <br>
                     <p>    
                        <label for="industry">Business Industry </label>
                        <select id="industry" name="industry">
                           <option value="<?php echo $business_info->industry; ?>"> select >></option>
                           <option <?= $business_info->industry == 'Admin/Business support'?'selected':''; ?> value="Admin/Business support">Admin/Business support</option>
                           <option <?= $business_info->industry == 'Agriculture, Forestry,Fishing and Hunting'?'selected':''; ?> value="Agriculture, Forestry,Fishing and Hunting">Agriculture, Forestry,Fishing and Hunting</option>
                           <option <?= $business_info->industry == 'Arts, Entertainment and Recreation'?'selected':''; ?> value="Arts, Entertainment and Recreation">Arts, Entertainment and Recreation</option>
                           <option <?= $business_info->industry == 'Constrution'?'selected':''; ?> value="Constrution">Constrution</option>
                           <option <?= $business_info->industry == 'Education'?'selected':''; ?> value="Education">Education</option>
                           <option <?= $business_info->industry == 'Finance and Insurance'?'selected':''; ?> value="Finance and Insurance">Finance and Insurance</option>
                           <option <?= $business_info->industry == 'Healthcare and Social Assistance'?'selected':''; ?> value="Healthcare and Social Assistance">Healthcare and Social Assistance</option>
                           <option <?= $business_info->industry == 'Hospitality'?'selected':''; ?> value="Hospitality">Hospitality</option>
                           <option <?= $business_info->industry == 'Information Technology'?'selected':''; ?> value="Information Technology">Information Technology</option>
                           <option <?= $business_info->industry == 'Manufacturing'?'selected':''; ?> value="Manufacturing">Manufacturing</option>
                           <option <?= $business_info->industry == 'Mining and Mineral processing'?'selected':''; ?> value="Mining and Mineral processing">Mining and Mineral processing</option>
                           <option <?= $business_info->industry == 'Professional, Scientific and Technical Services'?'selected':''; ?> value="Professional, Scientific and Technical Services">Professional, Scientific and Technical Services </option>
                           <option <?= $business_info->industry == 'Real Estate'?'selected':''; ?> value="Real Estate">Real Estate</option>
                           <option <?= $business_info->industry == 'Retail'?'selected':''; ?> value="Retail">Retail</option>
                           <option <?= $business_info->industry == 'Transport and Logistics'?'selected':''; ?> value="Transport and Logistics">Transport and Logistics</option>
                           <option <?= $business_info->industry == 'Other'?'selected':''; ?> value="Other">Other</option>
                        </select>
                     </p>
                    <br>
                     <p>Employees #: <input type="number" min="1" max="50" name="employees" value="<?php echo $business_info->employees; ?>"></p>
                    <br>
                     <p>Turnover (annual):  <input type="number" name="turnover" value="<?php echo $business_info->turnover; ?>"></p>
                    <br>
                     <p>Turnover (monthly, over 6 mo.s):  <input type="number" name="avg_6mo_turnover" value="<?php echo $business_info->avg_6mo_turnover; ?>"></p>
                    <br>
                     <p>
                        <span>Products and/Services</span><textarea name="offering" cols="40"
                        rows="2"><?php echo $business_info->offering; ?></textarea>
                     </p>
                    <br>
                     <p>
                        <span>How long has the business been in operation?</span>
                        <br>
                        <label for="business_duration">Start date</label>
                        <input type="date" name="business_duration" value="<?php echo $business_info->business_duration; ?>"/>
                     </p>
                     <br>
                     <p>
                        <span>How long has your business been operating on the premises?</span>
                        <br>
                        <label for="duration_on_premise">Start date</label>
                        <input type="date" name="duration_on_premise" value="<?php echo $business_info->duration_on_premise; ?>"/>
                     </p>
                     
                     <br>
                     <p>
                        <span>What bank is your company banking with?</span>
                        <select id="company_bank" name="acc_bank" value="<?php echo $business_info->acc_bank; ?>">
                           <option> -- select bank -- </option>
                           <option value="fnb">FNB</option>
                           <option value="nedbank">Nedbank</option>
                           <option value="standard bank">Standard Bank</option>
                           <option value="absa">Absa</option>
                           <option value="tyme bank">Tyme Bank</option>
                        </select>
                     </p>
                    <br>
                     <p class='turnover-opt'>
                        <span>What % of your turnover is:</span>
                        <div class="row">
                            <div class="col-md-4">
                                <div style="max-width:80px; margin-right: 0;">
                                    <span class="input-group-text" id="basic-addon3">Card</span>
                                    <input value="<?php echo $business_info->card_turnover; ?>" name="card_turnover" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div style="max-width:80px; margin-right: 0;">
                                    <span class="input-group-text" id="basic-addon3">Cash</span>
                                    <input value="<?php echo $business_info->cash_turnover; ?>" name="cash_turnover" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="max-width:80px; margin-right: 0;">
                                    <span class="input-group-text" id="basic-addon3">EFT</span>
                                    <input value="<?php echo $business_info->eft_turnover; ?>" name="eft_turnover" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                </div>
                            </div>
                        </div>

                     </p>

                     <div class="clear"></div>
                     <!--<button id="btn-save" type="submit">save 2</button>-->
                     <button type="submit">save</button>
                  </form>
               </div>











               <!-- business concept section -->
               <div class="biz-concept-area">
                  <h4>Business Concepts Questions</h4>
                  <hr class="divider">
                  <table>
                     <?php
                        $i = 0; ?>
                     <tr class="bg-info toggler" data-toggle="collapse" data-target="#section-1">
                        <td colspan="2" class="text-white"><?= $user_info->choice ?> <i class="fa fa-caret-up float-right"></i></td>
                     </tr>
                     <?php
                        foreach ($questions_seq[$user_info->choice] as $key => $cat) {
                            $i++;
                            ?>
                     <tbody id="section-1" class="collapse in show">
                        <?php
                           ?>
                        <tr>
                           <td colspan="2"><span style="font-size: large; color: #c38d9e; margin: 0;">
                              <i class="fa fa-certificate" aria-hidden="true"></i> <?= ucwords($cat) ?>
                              </span>
                           </td>
                        </tr>
                        <?php
                           $questions = $assessment->all_quesions_by_cat($cat);
                           foreach ($questions as $question):
                               ?>
                        <tr>
                           <input id="question_id" type="hidden" name="question_id[]"
                              value="<?= $question->question_id ?>"/>
                           <input id="user_id" type="hidden" name="user_id[]" value="<?= $logged_user_id ?>"/>
                           <td>
                              <span><i class="fa fa-question-circle"></i> <?= $question->question_text ?> </span>
                           </td>
                           <td>
                              <?php
                                 $ans_result = $db->query("SELECT * FROM q_answers WHERE user_id='$logged_user_id' AND question_id='$question->question_id'");
                                 $ans = $db->fetch_object($ans_result);
                                 $disabled = '';
                                 if (isset($ans) AND count($ans)>0) {
                                     $disabled = 'disabled';
                                 }
                                 ?>
                              <label><input <?= $disabled ?> id="yes" name="answers-<?= $question->question_id ?>" <?= (isset($ans) AND isset($ans->yes_answer) AND $ans->yes_answer == '1')?'checked':'' ?> type="checkbox" value=""> Yes </label>
                              <label><input <?= $disabled ?> id="no" name="answers-<?= $question->question_id ?>" <?= (isset($ans) AND isset($ans->no_answer) AND $ans->no_answer == '1')?'checked':'' ?> type="checkbox" value=""> No </label>
                           </td>
                        </tr>
                        <?php
                           endforeach;
                           echo '</tbody>';
                           }
                           $value_proposition_index = 0;
                           $customer_segments_index = 0;
                           $proof_of_concept_index = 0;
                           $channels_index = 0;
                           $customer_relationships_index = 0;
                           $revenue_streams_index = 0;
                           $key_activities_index = 0;
                           $key_resources_index = 0;
                           $key_partners_index = 0;
                           $cost_structures_index = 0;
                           $current_alternatives_index = 0;
                           $unique_index = 0;
                           if (0) {
                           foreach ($assessment->load_questions($logged_user_id) as $key => $value) {
                               $user_id = $logged_user_id;
                               $question_id = $value['question_id'];
                               $sub_category = $value['sub_category'];
                               $question_text = $value['question_text'];
                           
                               // business concept
                               if ($sub_category == 'value proposition') {
                                   $value_proposition_index += 1;
                                   if ($value_proposition_index == 1) {
                                       echo '
                                    <p>
                                       <span style="font-size: large; color: #c38d9e; margin: 0;">
                                           <i class="fa fa-certificate" aria-hidden="true"></i> Value proposition
                                       </span>
                                   </p>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input id="user_id" type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'customer segments') {
                                   $customer_segments_index += 1;
                                   if ($customer_segments_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                            <p>
                                                <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-users" aria-hidden="true"></i> Customer segment
                                               </span>
                                            </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'channels') {
                                   $channels_index += 1;
                                   if ($channels_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                            <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-bullhorn" aria-hidden="true"></i> Channels
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'customer relationships') {
                                   $customer_relationships_index += 1;
                                   if ($customer_relationships_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                            <span style="font-size: large; color: #C38D9E; margin: 0;">
                                               <i class="fa fa-heart" aria-hidden="true"></i> Customer relationships
                                           </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'revenue streams') {
                                   $revenue_streams_index += 1;
                                   if ($revenue_streams_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-money" aria-hidden="true"></i> Revenue streams
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'key activities') {
                                   $key_activities_index += 1;
                                   if ($key_activities_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-check-square-o" aria-hidden="true"></i> Key activities
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'key resources') {
                                   $key_resources_index += 1;
                                   if ($key_resources_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-check-square-o" aria-hidden="true"></i> Key Resources
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'key partners') {
                                   $key_partners_index += 1;
                                   if ($key_partners_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-check-square-o" aria-hidden="true"></i> Key partners
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'cost structure') {
                                   $cost_structures_index += 1;
                                   if ($cost_structures_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-dollar " ></i> Cost structure
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'current alternatives') {
                                   $current_alternatives_index += 1;
                                   if ($current_alternatives_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-graduation-cap" aria-hidden="true"></i> Current alternatives
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                               if ($sub_category == 'unique selling point') {
                                   $unique_index += 1;
                                   if ($unique_index == 1) {
                                       echo '
                                   <tr>
                                        <td colspan="2">
                                           <p>
                                               <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                   <i class="fa fa-files-o" aria-hidden="true"></i> Unique Selling Point
                                               </span>
                                           </p>
                                        </td>
                                    </tr>
                                   ';
                                   }
                           
                                   echo '
                               <tr>
                                   <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                   <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                   <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                   <td>
                                       <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                       <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                   </td>
                               </tr>';
                               }
                           }
                           }
                           ?>
                  </table>
                  <br>
                  <br>
                    <div class="summary-btn score-btn ">
                        <!-- <a href="entrepreneur-scores.php"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> See my report</a> -->
                        <a class="glow" href="entrepreneur-summary.php"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Report Summary</a>
                </div>
               </div>
               <!--/ business concept section -->
               <!-- business structure section -->
               <div class="biz-structure-area">
                  <h4> Business Structure Questions </h4>
                  <hr class="divider">
                  <table>
                     <?php
                        $talent_index = 0;
                        $marketing_index = 0;
                        $legal_index = 0;
                        $offering_index = 0;
                        $organization_index = 0;
                        $strategy_index = 0;
                        $fin_management = 0;
                        $employee_index = 0;
                        $functional_index = 0;
                        $growth_index = 0;
                        $compliance_index = 0;
                        $market_index = 0;
                        $commercial_index = 0;
                        $labor_index = 0;
                        $regulatory_index = 0;
                        $e_commerce_index = 0;
                        foreach ($assessment->load_questions($logged_user_id) as $key => $value) {
                            $user_id = $logged_user_id;
                            $question_id = $value['question_id'];
                            $sub_category = $value['sub_category'];
                            $question_text = $value['question_text'];
                        
                            // business structure
                            if ($sub_category == 'business process management') {
                                $organization_index += 1;
                                if ($organization_index == 1) {
                                    echo '
                                     <p class="questions-title"><span style="font-size: large; color: #C38D9E; margin: 0;">
                                            <i class="fa fa-tree" aria-hidden="true"></i> Business Process Management
                                        </span>
                                    </p>
                                    ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'marketing and sales') {
                                $marketing_index += 1;
                                if ($marketing_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="talent" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-bullhorn" aria-hidden="true"></i> Marketing and Sales
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'ownership and mindset') {
                                $talent_index += 1;
                                if ($talent_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="talent" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> Ownership and Mindset
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'employee satisfaction') {
                                $employee_index += 1;
                                if ($employee_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="talent" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-handshake-o" aria-hidden="true"></i> Employee Satisfaction
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'functional capability') {
                                $functional_index += 1;
                                if ($functional_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="talent" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-gavel" aria-hidden="true"></i> Functional Capability
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'business and customers') {
                                $strategy_index += 1;
                                if ($strategy_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-trophy" aria-hidden="true"></i> Business and Customers
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'growth strategy') {
                                $growth_index += 1;
                                if ($growth_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-line-chart" aria-hidden="true"></i> Growth Strategy
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'financial management') {
                                $fin_management += 1;
                                if ($fin_management == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-briefcase" aria-hidden="true"></i> Financial Management
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                    <tr>
                                        <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                        <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                        <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                        <td>
                                            <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                            <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                        </td>
                                    </tr>';
                            }
                            if ($sub_category == 'delivery and expertise') {
                                $offering_index += 1;
                                if ($offering_index == 1) {
                                    echo '
                                            <tr>
                                                 <td colspan="2">
                                                     <p class="questions-title">
                                                        <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                            <i class="fa fa-share-square-o" aria-hidden="true"></i> Delivery Expertise
                                                        </span>
                                                    </p>
                                                 </td>
                                             </tr>
                                             ';
                                }
                                echo '
                                    <tr>
                                        <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                        <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                        <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                        <td>
                                            <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                            <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                        </td>
                                    </tr>';
                            }
                            if ($sub_category == 'compliance and certification') {
                                $compliance_index += 1;
                                if ($compliance_index == 1) {
                                    echo '
                                            <tr>
                                                 <td colspan="2">
                                                     <p class="questions-title">
                                                        <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                            <i class="fa fa-hourglass-start" aria-hidden="true"></i> Compliance and Certification
                                                        </span>
                                                    </p>
                                                 </td>
                                             </tr>
                                             ';
                                }
                                echo '
                                    <tr>
                                        <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                        <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                        <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                        <td>
                                            <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                            <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                        </td>
                                    </tr>';
                            }
                            if ($sub_category == 'market intelligence') {
                                $market_index += 1;
                                if ($market_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-book" aria-hidden="true"></i> Market Intelligence
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'legal') {
                                $legal_index += 1;
                                if ($legal_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-book" aria-hidden="true"></i> Legal
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'commercial contracts agreements') {
                                $commercial_index += 1;
                                if ($commercial_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Commercial Contracts Agreements
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'labor compliance') {
                                $labor_index += 1;
                                if ($labor_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Labor Compliance
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'regulatory know') {
                                $regulatory_index += 1;
                                if ($regulatory_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Regulatory Know
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                            if ($sub_category == 'e-commerce') {
                                $e_commerce_index += 1;
                                if ($e_commerce_index == 1) {
                                    echo '
                                        <tr>
                                             <td colspan="2">
                                                 <p id="legal" class="questions-title">
                                                    <span style="font-size: large; color: #C38D9E; margin: 0;">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> E-commerce
                                                    </span>
                                                </p>
                                             </td>
                                         </tr>
                                         ';
                                }
                        
                                echo '
                                <tr>
                                    <input id="question_id" type="hidden" name="question_id[]" value="' . $question_id . '"/>
                                    <input type="hidden" name="user_id[]" value="' . $user_id . '"/>
                                    <td><span><i class="fa fa-question-circle"></i> ' . $question_text . ' </span></td>
                                    <td>
                                        <label><input id="yes" name="answers[]" type="checkbox" value=""> Yes </label>
                                        <label><input id="no" name="answers[]" type="checkbox" value=""> No </label>
                                    </td>
                                </tr>';
                            }
                        }
                        ?>
                  </table>
               </div>
               <!--/ business structure section -->
               <!-- score button-->
               
            </div>
         </div>
      </div>
      <div class="clear"></div>
      <nav class="navbar fixed-bottom navbar-light bg-light">
         <a class="navbar-brand" href="#">© 2021 Biz Tweak. All rights reserved</a>
      </nav>
      <?php if ($user_info->choice == '' || empty($user_info->choice)): ?>
      <div class="modal fade in" id="info-modal" style="background-color: rgba(0,0,0,.6);" data-backdrop="false">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Please select an option</h4>
                  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <form action="">
                     <div class="form-group">
                        <label>I would like to:</label><br>
                        <label><input value="Test my business idea" style="font-family:inherit;" type="radio"
                           name="choice" checked> Test my business idea</label> <a href="#" data-toggle="tooltip" title="Select this option if you want to test the structure of your business idea, do you have what is required to execute on it?"><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Get customers & revenue" style="font-family:inherit;" type="radio"
                           name="choice"> Get customers & revenue</label><a href="#" data-toggle="tooltip" title="Select this option if you want to find ways of how to reach your target audience."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Understand-Find my target market" style="font-family:inherit;"
                           type="radio" name="choice"> Understand-Find my target market</label><a href="#" data-toggle="tooltip" title="Select this option if you want to find ways of categorizing and locating your target audience and determining your ideal customer profile."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Get my business investor ready" style="font-family:inherit;"
                           type="radio" name="choice"> Get my business investor ready</label><a href="#" data-toggle="tooltip" title="Select this option if you want an all-around assessment of your business."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Know if I can scale my business" style="font-family:inherit;"
                           type="radio" name="choice"> Know if I can scale my business</label><a href="#" data-toggle="tooltip" title="Select this option if you want to know what you have to do to scale/grow your business."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Improve my employee performance" style="font-family:inherit;"
                           type="radio" name="choice"> Improve my employee performance</label><a href="#" data-toggle="tooltip" title="Select this option if you want to assess if you have the necessary tools and resources to support employee performance."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                        <label><input value="Start a business" style="font-family:inherit;" type="radio"
                           name="choice"> Start a business</label><a href="#" data-toggle="tooltip" title="Select this option to find out what are the things you need to have in place order to start a business."><i class="fa fa-info-circle" style="color: grey;margin-left: 4px;"></i></a><br>
                     </div>
                     <div class="form-group">
                        <button class="px-2 btn btn-danger" type="button" id="update-user-info">Use Biztweak Now
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="welcome-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Welcome to Biztweak</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <div class="text-justify">
                     <img src="images/logo2.png" class="img-fluid" alt="" style="height: 120px;">
                     <p class="lead">
                        Welcome to the BizTweak Platform, our aim is to make entrepreneurship easier for you, and we want to do this by helping you know what you don’t know, we want you to use our assessments as a tool to evaluate yourself, answer honestly and help us help you.
                     </p>
                  </div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="info-modal" data-dismiss="modal">Continue</button>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWgofmlaFcQk9PHyzTzDCJR3zWjcMg9kY&libraries=places"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script>
         let total_questions = $('.biz-concept-area input[type="checkbox"]').length/2;
         let answered = $('.biz-concept-area input[type="checkbox"]:checked').length;
         $(document).ready(function () {
             <?php if ($user_info->choice == '' || empty($user_info->choice)): ?>
             $("#welcome-modal").modal('toggle');
             $('#welcome-modal').on('hidden.bs.modal', function () {
                 $("#info-modal").modal('toggle');
             });
             <?php endif; ?>
             $('[data-toggle="tooltip"]').tooltip();
             var biz_info_btn = document.getElementById("biz-info-btn");
             var biz_structure_btn = document.getElementById("biz-structure-btn");
             var biz_concept_btn = document.getElementById("biz-concept-btn");
         
             $(biz_info_btn).click(function () {
                 $(".biz-info-area").show("slow");
                 $(".biz-structure-area").hide();
                 $(".biz-concept-area").hide();
             });
         
             $(biz_structure_btn).click(function () {
                 $(".biz-structure-area").show("slow");
                 $(".biz-info-area").hide();
                 $(".biz-concept-area").hide();
             });
         
             $(biz_concept_btn).click(function () {
                 $(".biz-concept-area").show("slow");
                 $(".biz-info-area").hide();
                 $(".biz-structure-area").hide();
             });
         
             // business info
             $('#profile-form').on("submit", function (event) {
                 event.preventDefault();
                 var formValues = $(this).serialize();
                 $.post("includes/function_update.php", formValues, function (data) {
                     $('#save-alert').show();
                     window.location.reload();
                 });
             })
         
             // Questions responses
             $(document).on("click", "#yes", function () {
                 var question_id = $(this).parents("tr").find("#question_id").val();
                 var yes_answer = 1;
                 var no_answer = 0;
                 $.post("includes/function_update.php", {
                     "form_type": "save-responses",
                     "question_id": question_id,
                     "yes_answer": yes_answer,
                     "no_answer": no_answer
                 }, function (data) {
                 });
                 $("input[name='answers-"+question_id+"'][id='no']").prop('checked',false);
                 $("input[name='answers-"+question_id+"'][id='yes']").prop('checked',true);
                 answered = $('.biz-concept-area input[type="checkbox"]:checked').length;
                 if (answered == total_questions) {
                     $('.summary-btn').removeClass('d-none');
                     $("#biz-concept-btn").removeClass('glow');
                 }
                 // $(this).parents("tr").fadeOut();
             })
             $(document).on("click", "#no", function () {
                 var question_id = $(this).parents("tr").find("#question_id").val();
                 var yes_answer = 0;
                 var no_answer = 1;
                 $.post("includes/function_update.php", {
                     "form_type": "save-responses",
                     "question_id": question_id,
                     "yes_answer": yes_answer,
                     "no_answer": no_answer
                 }, function (data) {
                 });
                 $("input[name='answers-"+question_id+"'][id='no']").prop('checked',true);
                 $("input[name='answers-"+question_id+"'][id='yes']").prop('checked',false);
                 answered = $('.biz-concept-area input[type="checkbox"]:checked').length;
                 if (answered == total_questions) {
                     $('.summary-btn').removeClass('d-none');
                     $("#biz-concept-btn").removeClass('glow');
                 }
                 // $(this).parents("tr").fadeOut();
             })
         });
         /*$('#profile-form').submit(function(e) {
             e.preventDefault();
             $.ajax({
                 method: "POST",
                 url: "includes/function_update.php",
                 data: $(this).serialize()
               })
             .done(function() {
                 $('#profile-alert').show();
             });
         });*/
         $("#update-user-info").on("click", (e) => {
             let choice = $("input[name=choice]:checked").val();
             $.ajax({
                 url: '<?= $_SERVER["PHP_SELF"] ?>',
                 method: 'POST',
                 data: {
                     'update-info': 1,
                     'choice': choice
                 },
                 success: (r) => {
                     $("#info-modal").modal('toggle');
                 }
             })
         });
         $(".toggler").click((e)=>{
             $(e.target).find('.fa.float-right').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
         })
      </script>
      <script type="text/javascript">
         var placeSearch, autocomplete, geocoder;
         function initAutocomplete() {
             geocoder = new google.maps.Geocoder();
             autocomplete = new google.maps.places.Autocomplete(
                 (document.getElementById('autocomplete')), {
                     types: ['geocode']
                 });
             autocomplete.addListener('place_changed', fillInAddress);
         }
         function codeAddress(address) {
             geocoder.geocode({
                 'address': address
             }, function (results, status) {
                 if (status == 'OK') {
                     // This is the lat and lng results[0].geometry.location
                     // alert(results[0].geometry.location);
                 } else {
                     // alert('Geocode was not successful for the following reason: ' + status);
                 }
             });
         }
         
         function fillInAddress() {
             var place = autocomplete.getPlace();
         
             codeAddress(document.getElementById('autocomplete').value);
         }
         $(document).ready(function () {
             if ($('#autocomplete').length > 0) {
                 initAutocomplete();
             }
         });
      </script>
   </body>
</html>