<?php
    /* REGISTRATION CLASS */
    session_start();
    require_once 'class_database.php';
    $db = new database;

    class registration {

        public function basicUserRegistration($name, $username, $en_password, $type, $code){
            global $db;

            // inserting user's sign in details to signin table
			$query = "INSERT INTO signin(username, password)
                        VALUES('$username', '$en_password')";
            $db->query($query);

            // fetch user_id to insert on users table
            $user_id = $this->fetchUserId($username);
            // fetch consultant id to insert on relation table
            $consultant_id = $this->fetchConsultantId($code);
            // insert user's information to users table
            if ($type == 3){
                // insert information to relations table
                $query = "INSERT INTO relation(entrepreneur_id, consultant_id)
                            VALUES('$user_id', '$consultant_id')";
                $db->query($query);

                // insert entrepreneur's business indoemation to businesses table
                $query = "INSERT INTO businesses(user_id)
                            VALUES('$user_id')";
                $db->query($query);
                $code = "";
            }
			$query = "INSERT INTO users(name, user_id, user_type, email, code)
                        VALUES('$name', '$user_id', '$type', '$username', '$code')";
            $db->query($query);

            // when all the queries are successful, create sessions
            if($query){
                session_regenerate_id;

                $_SESSION['SESS_USER_ID'] = $user_id;
                $_SESSION['SESS_TYPE'] = $type;

                session_write_close();
                if ($type == 3){
                    header("location: entrepreneur.php");
                }
                else if ($type == 2){
                    header("location: consultant.php");
                }
                exit();
            }

            else {
		        die("Query failed");
	        }

        }

        private function insertUser($user, $type, $username, $code){
            global $db;

            $query = "INSERT INTO users(user_id, user_type, email, code)
                        VALUES('$user_id', '$type', '$username', '$code')";

            $db->query($query);
        }

        public function fetchUserId($username){
            $results = $this->getUserIdObject($username);
            $user_Id = $results->user_id;
            return $user_Id;
        }

        private function getConsultantId($code){
            global $db;
            $query = "SELECT user_id FROM users WHERE code = '$code'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results[0];
        }

        public function fetchconsultantId($code){
            $results = $this->getConsultantId($code);
            $user_Id = $results->user_id;
            return $user_Id;
        }

        private function getUserIdObject($username){
            global $db;
            $query = "SELECT user_id FROM signin WHERE username = '$username'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results[0];
        }

        public function isCodeExist($code){
            global $db;
            $query = "SELECT code FROM users WHERE code = '$code'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return @$results;
        }

        public function usernameExist($username){
            global $db;
            $query = "SELECT email FROM users WHERE email = '$username'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return @$results;
        }

    }
?>
