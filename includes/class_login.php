<?php
    /* LOG IN CLASS */

    // STARTING SESSIONS
    session_start();

    // INCLUDED FILES
    require_once 'class_database.php';
    // include 'module_access.php';
    // include '/../lib/Browser.php-master/lib/Browser.php';
    // include '/../lib/Mobile-Detect-master/Mobile_Detect.php';


    // OBJECTS
    $db = new database;
    // $br = new Browser;
    // $dev = new Mobile_Detect;

    // LOGIN CLASS
    class login{
        // VARIABLES
        private $user_id;
        private $user_type;

        // A FUNCTION TO LOGIN USER VIA USERNAME AND PASSWORD
        function normalLogin($username, $password){
            // DATABASE VARIABLE
            global $db;

            // BASIC AUTHENTIFICATION
            $results = $this->basicAuth($username);

            // WHEN THE QUERY IS RUNNING SUCCESSFUL
            if(!empty($results)){

                // ASIGNING VARIABLES
                $user_id = $results->user_id;
                $user_type = $results->user_type;

                // GENERATING SESSION ID
                session_regenerate_id();

                // LOGGING IN AN ADMIN
                if($results->user_type == 1){
                    $this->isAdmin($results);
                }

                //LOGGING IN A USER
                if($results->user_type == 3){
                    $this->isUser($results);
                }

                // LOGGING IN A COMPANY
                if($results->user_type == 2){
                    $this->isCompany($results);
                }
            }

            // WHEN THE QUERY WAS UNSUCCESSFUL
            else {
                header("location: ../login.php");
                exit();
            }
        }

        //  A METHOD TO DO BASIC AUTHENTIFICATION IN LOGIN TABLE
        private function basicAuth($username){

            // DATABASE VARIABLE
            global $db;

            // SELECTING AND VERIFYING USER LOGIN DETAILS IN LOGIN TABLE
            $query = "SELECT email, user_type, user_id
                      FROM users
                      WHERE email = '$username' ";

            // RUNNING THE QUERY AND PULLING RESULTS
            $result = $db->query($query) or die("Couldn't execute query");

            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            // RETURNING RESULTS
            return $results[0];
        }

        // A METHOS TO LOG IN AN ADMIN
        private function isAdmin($results){
             global $db;
            // CREATING SESSIONS
		    $_SESSION['SESS_USER_ID'] = $results->user_id;
            $_SESSION['SESS_TYPE'] = $results->user_type;
		    session_write_close();

            // REDIRECTING TO ADMIN PAGE
            if(!empty($_SESSION['SESS_USER_ID'])){
			    header("location: admin.php");
			    exit();
            }

            // WHEN FAILED TO LOG IN
            else{
              echo "FAILED TO LOG IN";
            }
        }

        // A METHOD TO LOG IN AN ENTREPRENEUR
        private function isUser($results){
            global $db;
            // CREATING SESSIONS
			$_SESSION['SESS_USER_ID'] = $results->user_id;
            $_SESSION['SESS_TYPE'] = $results->user_type;
			session_write_close();

            // REDIRECTING TO ENTREPRENEUR PAGE
            if(!empty($_SESSION['SESS_USER_ID']) && !empty($_SESSION['SESS_TYPE'])){
			    header("location: entrepreneur.php");
			    exit();
            }

            // WHEN FAILED TO LOG IN
            else{
              echo "FAILED TO LOG IN";
            }
        }
        // A METHOD TO LOG IN A CONSULTANT
        private function isCompany($results){
            global $db;
            // CREATING SESSIONS
            $_SESSION['SESS_USER_ID'] = $results->user_id;
            $_SESSION['SESS_TYPE'] = $results->user_type;
            session_write_close();

            // REDIRECTING TO TIMELINE PAGE
            if(!empty($_SESSION['SESS_USER_ID'])){
			    header("location: consultant.php");
			    exit();
            }

            // WHEN FAILED TO LOG IN
            else{
              echo "FAILED TO LOG IN";
            }
        }

    }

?>
