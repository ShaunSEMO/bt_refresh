<?php
    // DATABASE OBJECT
    $db = new database;

    // REGISTRATION OBJECT
    $registerUser = new registration;

    if(!empty($_POST)){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rpassword = $_POST['rpassword'];
        $type = $_POST['type'];
		$code = $_POST['consultant_code'];

        $error = array();

        if(empty($username)){
            $error[] = 'username field is empty!';
        }
        elseif(strlen($username) < 2){
            $error[] = 'username too short';
        }

        if(empty($password)){
            $error[] = 'password field is empty';
        }
        elseif(strlen($password) < 6){
            $error[] = 'password too short (min 6 characters)';
        }

        if(empty($rpassword)){
            $error[] = 'repeat password field is empty';
        }
        elseif(strlen($rpassword) < 6){
            $error[] = 'repeat password too short (min 6 characters)';
        }

        if($password !== $rpassword){
            $error[] = 'password do not match';
        }

        if(empty($type)){
            $error[] = 'you did not select any option';
        }

        $username_av = $registerUser->usernameExist($username);
        if ($username_av > 0) {
            $error[] = 'sorry, username already exist';
        }
        else{
            if((!empty($username))
                && (!empty($name))
                && (!strlen($username) < 2)
                && (!empty($password))
                && (!strlen($rpassword) < 6)
                && (!empty($rpassword))
                && (!strlen($rpassword) < 6)
                && ($password == $rpassword)
                && ($username_av < 1)
                && (!empty($type))){
                        if($type == 'consultant'){
                            $code = "biz".rand(100,1000);
                            $type = 2;
                            $en_password = sha1($password);
							// register the consultant
							$registerUser->basicUserRegistration($name, $username, $en_password, $type, $code);

						}

                        if($type == 'entrepreneur'){
							if (empty($code)){
								$error[] = 'please provide your consultant code';
							}
                            if (!(strlen($code) == 6)){
                                $error[] = 'consultant code is not valid';
                            }
                            // check if the consultant code is available
                            $code_av = $registerUser->isCodeExist($code);
                            if($code_av < 1){
                                $error[] = 'the code does not exist';
                            }
                            else {
                                if(!empty($code)
                                && (strlen($code != 5))
                                && ($code_av > 1)){
                                    $error[] = 'everything is fine';
                                    $type = 3;
                                    $en_password = sha1($password);
                                    // register the consultant
                                    $registerUser->basicUserRegistration($name, $username, $en_password, $type, $code);
                                }
                            }
                        }
                }
        }
    }

	function get_userid($username){
		global $db;

		$query = "SELECT user_id FROM signin WHERE username = '$username'";

		$result = $db->query($query);

		while($obj = $result->fetch_object()){
			$results[] = $obj;
		}

		return $results[0];
	}

    function searchUsername($username){
        global $db;

        $query = "SELECT username FROM login WHERE BINARY username = '$username'";
        $results = $db->query($query);

        return $results;
    }

    function searchUsernameFromMembers($username){
        global $db;

        $query = "SELECT username FROM members WHERE BINARY username = '$username'";
        $results = $db->query($query);

        return $results;
    }

    function searchUsernameFromCompanies($username){
        global $db;

        $query = "SELECT username FROM companies WHERE username = '$username'";
        $results = $db->query($query);

        return $results;
    }

?>
