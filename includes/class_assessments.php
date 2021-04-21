<?php

class assessments{

    public function all_quesions(){
        global $db;
        $query = "SELECT * FROM questions";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }
    public function all_quesions_ids(){
        global $db;
        $query = "SELECT question_id, sub_category FROM questions";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function all_quesions_by_cat($cat){
        global $db;
        $query = "SELECT * FROM questions WHERE sub_category = '".strtolower($cat)."'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function all_quesion_ids_by_cat($cat){
        global $db;
        $query = "SELECT question_id FROM questions WHERE sub_category = '".strtolower($cat)."'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function num_all_questions(){
        global $db;
        $query = "SELECT question_id FROM questions";
        $result = $db->query($query);
        $num = $db->num_rows($result);
        return $num;
    }

    public function answered_questions($logged_user_id){
        global $db;
        $results = array();
        $query = "SELECT question_id FROM q_answers WHERE user_id = '$logged_user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_assoc()){
            $results[] = $obj;
        }
        return $results;
    }

    public function num_answered_questions($logged_user_id){
        $answered_questions = $this->answered_questions($logged_user_id);
        $num_answered = count($answered_questions);
        return $num_answered;
    }

    private function is_q_answered($question_id, $logged_user_id){
        global $db;
        $query = "SELECT question_id FROM q_answers WHERE question_id = '$question_id' AND user_id = '$logged_user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    private function unanswered_q($logged_user_id){
        $all_questions = $this->all_quesions_ids();
        $un_answered_arr = array();
        foreach ($all_questions as $val){
            $question_id = $val->question_id;
            if(empty($this->is_q_answered($question_id, $logged_user_id))){
                $un_answered_arr[] = $question_id;
            }
        }

        return $un_answered_arr;
    }

    public function unanswered_questions($logged_user_id){
        $all_questions = $this->all_quesions_ids();
        $answered_questions = $this->answered_questions($logged_user_id);
        $un_answered = 0;//array_diff_assoc($all_questions, $answered_questions);
        // $un_answered = $all_questions - $answered_questions;
        return $un_answered;
    }

    public function is_question_answered($user_id, $question_id){
        global $db;

        $query = "SELECT * FROM q_answers WHERE user_id = '$user_id' AND question_id = '$question_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    public function num_unanswered($logged_user_id){
        global $db;
        $un_answered = $this->unanswered_questions($logged_user_id);
        $num_unanswered = count($un_answered);
        return $num_unanswered;
    }

    public function question_info($question_id){
        global $db;

        $query = "SELECT * FROM questions WHERE question_id  = '$question_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    private function check_sub_category($question_id, $sub_category){
        global $db;
        $query = "SELECT sub_category FROM questions WHERE question_id = '$question_id' AND sub_category = '$sub_category'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    private function check_s_category($question_id){
        global $db;
        $query = "SELECT sub_category, question_text FROM questions WHERE question_id = '$question_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_assoc()){
            $results[] = $obj;
        }
        return $results[0];
    }

    public function load_questions($logged_user_id){
        $un_answered = $this->unanswered_q($logged_user_id);
        $all_questions = array();
        foreach($un_answered as $val){
            $question_id = $val;
            $pre_arr= $this->check_s_category($question_id);
            $sub_category = $pre_arr['sub_category'];
            $question_text = $pre_arr['question_text'];
            $all_questions[] = array(
                'sub_category' => $sub_category,
                'question_id' => $question_id,
                'question_text' => $question_text);
        }
        return $all_questions;
    }

    public function save_questions($user_id, $question_id, $yes_status, $no_status){
        global $db;
        $query = "INSERT INTO q_answers(user_id, question_id, yes_answer, no_answer)
                    VALUES('$user_id', '$question_id', '$yes_status', '$no_status')";
        $db->query($query);
    }

    public function followers($logged_user_id){
        global $db;
        $query = "SELECT entrepreneur_id FROM relation WHERE consultant_id = '$logged_user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function check_assessments($user_id){
        global $db;
        $results = array();
        $query = "SELECT * FROM q_answers WHERE user_id = '$user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function get_biz_rating($user_id){
        global $scores;
        $user_scores = $scores->score_q($user_id);
        $total_avg = 0;
        foreach ($user_scores as $key => $score) {
            if ($score['average'] !== 'NAN') {
                $total_avg += $score['average'];
            }
        }
        return round($biz_rating = ($total_avg / (count($user_scores) * 100)) * 100).'%';
    }

    public function display_incomplete_a($logged_user_id){
        global $db;
        global $logged_user;

        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);
            // user's information
            $user_info = $logged_user->user_info($user_id);
            $user_name = $user_info->name;
            $email = $user_info->email;
            $business_info = $logged_user->business_info($user_id);
            $biz_name = $business_info->name;
            $biz_address = $business_info->address;
            $biz_phase = $business_info->stage;
            $industry = $business_info->industry;
            $employees = $business_info->employees;
            $turnover = $business_info->turnover;
            $incomplete_assessments = $this->get_incomplete_assessment($user_id);
            $i_assess = implode(", ",$incomplete_assessments);
            // incompleted assessments
            if ($num_asses < 90){
                echo '
                <tr>
                    <td>'.$user_name.'</td>
                    <td>'.$email.'</td>
                    <td>'.$biz_name.'</td>
                    <td>'.$biz_address.'</td>
                    <td>'.$biz_phase.'</td>
                    <td>'.$industry.'</td>
                    <td>'.$employees.'</td>
                    <td>'.$turnover.'</td>
                    <td>'.$i_assess.'</td>
                </tr>
                ';
            }
        }
    }

    public function first_follower($logged_user_id){
        global $db;
        global $logged_user;
        global $scores;

        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);
            if ($num_asses > 50){
                return $user_id;
            break;
            }
        }
    }

    public function display_complete_box($logged_user_id){
        global $db;
        global $logged_user;
        global $scores;

        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);
            // user's information
            $user_info = $logged_user->user_info($user_id);
            $user_name = $user_info->name;
            $business_info = $logged_user->business_info($user_id);
            $biz_name = $business_info->name;
            $user_scores = $scores->score_q($user_id);
            // incompleted assessments
            if ($num_asses > 50){
                echo '
                    <form action="scores.php" method="post">
                    <input id="user_id" type="hidden" name="user_id" value="'.$user_id.'"/>
                    <input id="user_id" type="hidden" name="name" value="'.$user_name.'"/>
                    <input style="border: none; margin:5px 0;"type="submit" value="'.$user_name.' - '.$biz_name.'"/>
                    </form>
                ';
            }
        }
    }

    public function display_complete_a($logged_user_id){
        global $db;
        global $logged_user;
        global $scores;

        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);
            // user's information
            $user_info = $logged_user->user_info($user_id);
            $user_name = $user_info->name;
            $email = $user_info->email;
            $business_info = $logged_user->business_info($user_id);
            $biz_name = $business_info->name;
            $biz_address = $business_info->address;
            $user_info = $logged_user->user_info($user_id);
            $user_name = $user_info->name;
            $biz_phase = $business_info->stage;
            $industry = $business_info->industry;
            $employees = $business_info->employees;
            $turnover = $business_info->turnover;
            $user_scores = $scores->score_q($user_id);
            // incompleted assessments
            if ($num_asses > 89){
                echo '
                    <tr>
                        <input id="user_id" type="hidden" name="user_id" value="'.$user_id.'">
                        <td id="user_name">'.$user_name.'</td>
                        <td>'.$email.'</td>
                        <td>'.$biz_name.'</td>
                        <td>'.$biz_address.'</td>
                        <td>'.$biz_phase.'</td>
                        <td>'.$industry.'</td>
                        <td>'.$employees.'</td>
                        <td>'.$turnover.'</td>
                        <td>'.$this->get_biz_rating($user_id).'</td>
                    <td>
                        <form method="post" action="scores.php">
                        <input type="hidden" name="user_id" value="'.$user_id.'">
                        <input type="hidden" name="name" value="'.$user_name.'">
                        <!-- Button to the score page -->
                        <button id="view-report" type="submit" class="btn btn-primary">
                            view report
                        </button>
                        </form>
                    </td>
                    </tr>
                ';
            }
        }
    }

    public function get_incomplete_assessment($user_id){
        global $db;
        $categories = [];
        $query = "SELECT DISTINCT sub_category FROM questions";
        $res = $db->query($query);
        $incomp = [];
        while($row = $res->fetch_assoc()){
            $categories[] = $row;
        }
        foreach ($categories as $key => $category) {
            $total_q = 0;
            $q_answered = 0;
            $type = $category['sub_category'];
            $questions = $this->all_quesion_ids_by_cat($type);
            $total_q += count($questions);
            foreach($questions as $q){
                $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                if($db->query($query)->num_rows > 0){
                    $q_answered++;
                }
            }
            if ($q_answered < $total_q) {
                $incomp[] = $type;
            }
        }
        return $incomp;
        exit;
    }

    public function num_incomplete_assessment($logged_user_id){
        $counter = 0;
        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);
            // incomplete assessments
            if ($num_asses < 90){
                $counter = $counter + 1;
            }
        }
        return $counter;
    }

    public function num_complete_assessments($logged_user_id){
        $counter = 0;
        $followers = $this->followers($logged_user_id);
        foreach ($followers as $v){
            $user_id = $v->entrepreneur_id;
            $asses = $this->check_assessments($user_id);
            $num_asses = count($asses);

            // completed assessments
            if ($num_asses > 89){
                $counter = $counter + 1;
            }
        }
        return $counter;
    }

    private function all_concept_questions(){
        global $db;

        $query = "SELECT * FROM questions WHERE category = 'concept'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }
    private function all_structure_questions(){
        global $db;

        $query = "SELECT * FROM questions WHERE category = 'structure'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    public function load_concept_questions(){
        return $this->all_concept_questions();

        /*foreach($concept_questions as $val){
            echo '
            <tr>
            <td>'.$val->sub_category.'</td>
            <td>
                <textarea rows="3" cols="60">
                '.$val->question_text.'
                </textarea>
            </td>
            <td><button> Delete </button> <button> update </button></td>
          </tr>
            ';
        }*/
    }

    public function load_structure_questions(){
        return $this->all_structure_questions();
        /*foreach($structure_questions as $val){
            echo '
            <tr>
            <td>'.$val->sub_category.'</td>
            <td>
                <textarea rows="3" cols="60">
                '.$val->question_text.'
                </textarea>
            </td>
            <td><button> Delete </button> <button> update </button></td>
          </tr>
            ';
        }*/
    }

    // number of all questions
    public function progress_bar($logged_user_id){
        $num_concept = count($this->num_concept_q());
        $num_structure = count($this->num_structure_q());
        $concept_arr = $this->num_concept_q();
        $structure_arr = $this->num_structure_q();
        $bizinfo_arr = $this->num_bizinfo_q($logged_user_id);

        $concept_index = 0;
        $structure_index = 0;
        $biz_info_index = 0;
        $progress_arr = array();

        // biz info questions
        foreach ($bizinfo_arr as $value){
            if (!empty($value->name)) { $biz_info_index += 1; }
            if (!empty($value->number)) { $biz_info_index += 1; }
            if (!empty($value->date)) { $biz_info_index += 1; }
            if (!empty($value->address)) { $biz_info_index += 2; }
            if (!empty($value->stage)) { $biz_info_index += 1; }
            if (!empty($value->industry)) { $biz_info_index += 1; }
            if (!empty($value->offering)) { $biz_info_index += 1; }
        }

        // concept questions
        foreach ($concept_arr as $val){
            $question_id = $val->question_id;
            if (!empty($this->is_question_answered($logged_user_id, $question_id))) {
                $concept_index += 1;
            }
        }

        foreach ($structure_arr as $val2){
            $question_id = $val2->question_id;
            if (!empty($this->is_question_answered($logged_user_id, $question_id))){
                $structure_index += 1;
            }
        }

        $grand_total = $num_concept + $num_structure + 8;
        $sum_all = $concept_index + $structure_index + $biz_info_index;
        $progress_num = $sum_all / $grand_total * 100;
        if ($progress_num <= 20){ $progress_arr['color'] = "#FFFF33";}
        if ($progress_num > 20 && $progress_num <= 65) { $progress_arr['color'] = "#0066CC";}
        if ($progress_num > 65) {$progress_arr['color'] = "#32CD32";}
        $progress_arr['score'] = round($progress_num);
        return $progress_arr;
    }

    // number of biz info questions
    private function num_bizinfo_q($logged_user_id){
        global $db;
        $results = array();
        $query = "SELECT * FROM businesses WHERE user_id = '$logged_user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    // number of concept questions
    private function num_concept_q(){
        global $db;
        $results = array();
        $query = "SELECT question_id FROM questions WHERE category = 'concept'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

    // number of structure questions
    private function num_structure_q(){
        global $db;
        $results = array();
        $query = "SELECT question_id FROM questions WHERE category = 'structure'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results;
    }

}
?>
