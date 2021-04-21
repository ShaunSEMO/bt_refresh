<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
include 'includes/class_registration.php';
include 'vendor/autoload.php';

$type = isset($_GET['type'])?$_GET['type']:$_SESSION['hybrid_login_type'];
if (!isset($_SESSION['hybrid_login_type'])) {
    $_SESSION['hybrid_login_type'] = $type;
}
$config = [
    // Location where to redirect users once they authenticate with a provider
    'callback' => 'https://mbilalmirza.com/projects/biztweak/social-auth.php',

    // Providers specifics
    'providers' => [
        'Facebook' => ['enabled' => true, 'keys' => ['id' => '1299145490467112', 'secret' => 'c16c2f631b87d7cc8e9536115d9ed81a']],
        'Google' => ['enabled' => true, 'keys' => ['id' => '694216361397-ed95rlft44rvtsb24mdvoeke2mfs0sg4.apps.googleusercontent.com', 'secret' => 'pTksykw1b7SesAXQjhmr0i1x']]
    ]
];

try {
    // Instantiate Facebook's adapter directly
    $hybridauth = new Hybridauth\Hybridauth($config);

    // Attempt to authenticate the user with Facebook
    $adapter = $hybridauth->authenticate($type);

    // Returns a boolean of whether the user is connected with Facebook
    $isConnected = $adapter->isConnected();

    // Retrieve the user's profile
    $userProfile = $adapter->getUserProfile();
    // Inspect profile's public attributes
    $name = $userProfile->displayName;
    $email = $userProfile->email;
    $res = $db->query("SELECT * FROM users WHERE email='$email' AND login_type='$type'");
    if ($db->num_rows($res) > 0) {
        $data = $db->fetch_assoc($res);
        $_SESSION['SESS_USER_ID'] = $data['user_id'];
        $_SESSION['SESS_TYPE'] = $data['user_type'];
        if ($data['user_type'] == '2') {
            header('Location: consultant.php');
        }else{
            header('Location: entrepreneur.php');
        }
        exit;
    }else{
        $query = "INSERT INTO signin(username, password) VALUES('$email', '')";
        $db->query($query);
        $user = new registration();
        echo $user_id = $user->fetchUserId($email);
        $query = "INSERT INTO users(name, user_id, email, login_type)
                    VALUES('$name', '$user_id', '$email', '$type')";
        $db->query($query);
        $_SESSION['SESS_USER_ID'] = $user_id;
        header('Location: step.php');
        exit;
    }

    // Disconnect the adapter (log out)
    $adapter->disconnect();
}
catch(\Exception $e){
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
