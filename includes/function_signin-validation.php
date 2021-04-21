<?php
    // DATABASE OBJECT
    $db = new database;

    //$is_user_known = FALSE;

    // CHECKS IF THERE ARE POST VARIABLES
    if(!empty($_POST)){

        // POST VARIABLES FROM THE FORM
        $username = $_POST['username'];
        $password = $_POST['password'];

        // VALIDATION ERROR MESSAGES
        $error = array();

        // CHECKS IF USERNAME IS AVAILABLE IF NOT IT WRITES ERROR MESSAGE
        if($username == ''){
            $error[] = 'username field empty!';
        }

        // CHECKS IF USERNAME'S LENGTH IS 3 AND MORE CHARACTERS IF NOT IT WRITES ERROR MESSAGE
        elseif(strlen($username) < 2){
            $error[] = 'username too short!';
        }

        // CHECKS IF PASSWORD IS AVAILABLE IF NOT IT WRITES ERROR MESSAGE
        if($password == ''){
            $error[] = 'password field empty!';
        }

        // CHECKS IF PASSWORD'S LENGTH IS 6 AND MORE CHARACTERS IF NOT IT WRITES ERROR MESSAGE
        elseif(strlen($password) < 6){
            $error[] = 'password too short!';
        }

        // THEN IF NOTHING IS WRONG WITH THE FORM VARIABLES
        else{
            // CHECKS IF THE PROVIDED USERNAME DOES EXISTS OR NOT
            $query = "SELECT username FROM signin WHERE BINARY username = '$username'";
            $results = $db->query($query);

            // IF THE USERNAME PROVIDED DOES NOT EXIST AND WRITE ERROR MESSSAGE
            if($db->num_rows($results) < 1){
               $error[] = 'username does not exist';
            }

            // IF THEN A PROVIDED USERNAME EXISTS 
            if($db->num_rows($results) == 1){

                // DENCRYPTING PASSWORD VARIABLE
                $en_password = sha1($password);

                // CHECKS IF THE USERNAME AND PASSWORD PROVIDED MATCHES WITH ONES IN THE LOGIN TABLE
                $auth_query = "SELECT username 
                               FROM signin 
                               WHERE username = '$username'
                               AND password = '$en_password'";
                // RUNNING THE QUERY
                $auth_results = $db->query($auth_query);

                // IF THE PASSWORD AND USERNAME DOES NOT MATCH AND WRITES ERROR MESSAGE
                if($db->num_rows($auth_results) < 1){

                    $error[] = 'password incorrect';
                }

                // IF THE USERNAME AND PASSWORD MATCHES THEN FORWARD THE USER TO LOGIN CLASS
                else{
                    // LOG IN CLASS OBJECT
                    $login = new login;
                    // AUTHENTICATING METHOD IN LOGIN CLASS
                    $login->normalLogin($username, $en_password);
                }
            }

        }

    }
?>
