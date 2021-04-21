<?php

class user {
    private function logged_user_id(){
        $user_id = $_SESSION['SESS_USER_ID'];
        return $user_id;
    }
    private function logged_user_type(){
        $user_type = $_SESSION['SESS_TYPE'];
        return $user_type;
    }
    public function get_logged_user_id(){
        $user_id = $this->logged_user_id();
        return $user_id;
    }

    public function get_logged_user_type(){
        $user_type = $this->logged_user_type();
        return $user_type;
    }

    // business information questions
    public function business_info($user_id){
        global $db;
        $results = array();
        $query = "SELECT * FROM businesses WHERE user_id = '$user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    public function user_info($user_id){
        global $db;
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }

    public function user_info_by_id($user_id){
        global $db;
        $query = "SELECT * FROM users WHERE id = '$user_id'";
        $result = $db->query($query);
        while($obj = $result->fetch_object()){
            $results[] = $obj;
        }
        return $results[0];
    }


    public function save_biz_info($user_id,
                                  $name, $number, $date,
                                  $address, $bio, $phase,
                                  $industry, $offering,$turnover, $employees){
        global $db;
        if ($db->query("SELECT * FROM businesses WHERE user_id='$user_id'")->num_rows > 0) {
            $query = "UPDATE businesses
            SET name = '$name',
            number = '$number',
            date = '$date',
            address = '$address',
            bio = '$bio',
            stage = '$phase',
            industry = '$industry',
            offering = '$offering',
            turnover = '$turnover',
            employees = '$employees'
            WHERE user_id = '$user_id'";
        }else{
            $query = "INSERT INTO businesses
            SET name = '$name',
            number = '$number',
            date = '$date',
            address = '$address',
            bio = '$bio',
            stage = '$phase',
            industry = '$industry',
            offering = '$offering',
            user_id = '$user_id',
            turnover = '$turnover',
            employees = '$employees'";
        }
        echo $query;
        $db->query($query);
    }

    public function save_profile_info($user_id, $name, $designation, $location,
                                        $education, $status, $biz_type,
                                        $biz_stage, $biz_bio, $biz_choice, $offering){
        global $db;
        $query = "UPDATE users
                    SET name = '$name',
                        designation = '$designation',
                        location = '$location',
                        education = '$education',
                        status = '$status',
                        biz_type = '$biz_type',
                        biz_stage = '$biz_stage',
                        bio = '$biz_bio',
                        choice = '$biz_choice',
                        offering = '$offering'
                    WHERE user_id = '$user_id'";
        if ($db->query($query)){
            return TRUE;
        }
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

    public function num_followers($logged_user_id){
        $num = $this->followers($logged_user_id);
        return count($num);
    }

    public function display_followers($logged_user_id)
    {
        global $db;
        $followers = $this->followers($logged_user_id);
        if (empty($followers)) {
            echo '<p>Currently you do not have Entrepreneurs added under your profile</p>';
        } else {

            foreach ($followers as $f) {
                $user = $f->entrepreneur_id;
                $query = "SELECT * FROM users WHERE user_id = '$user'";
                $result = $db->query($query);
                while ($obj = $result->fetch_object()) {
                    $results[] = $obj;
                }
            }
            echo '<div class="dropdown">
              <button class="px-2 btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Entrepreneurs
                  <span class="caret"></span></button>
              <ul class="dropdown-menu">';
            foreach ($results as $r) {
                echo '<li><a data-toggle="modal" data-target="#user-modal" data-id="'.$r->id.'" class="fetch-user p-2 text-decoration-none d-block" href="#"><i style="color: #41B3A3;" class="fa fa-user" aria-hidden="true"></i> ' . $r->name . '</a></li>';
            }
            echo '</ul></div>';
        }
    }
}
?>
