<?php 

include '../includes/class_database.php';
$db = new database;

if(!empty($_POST)){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $fax = $_POST['fax'];
    $website = $_POST['website'];
    $type = $_POST['type'];
    $vat = $_POST['vat'];

    $error = array();

    if(empty($name)){
        $error[] = 'company name field is empty!';
    }
    elseif(strlen($name) < 2){
        $error[] = 'company name too short';
    }

    if(empty($address)){
        $error[] = 'address field is empty';
    }
    elseif(strlen($address) < 2){
        $error[] = 'address too short';
    }


    if(empty($type)){
        $error[] = 'you did not select any option';
    }

    else {
        if (!empty($name) &&
            (strlen($name) > 2) &&
            (!empty($address)) &&
            (strlen($address) > 2)){
                registerUser($name, $address, $number, $email, $fax, $website, $type, $vat);
            }
    }
}

function registerUser($name, $address, $number, $email, $fax, $website, $type, $vat){
    global $db;
    $query = "INSERT INTO smme_ecosystem(company_name, address, contact, email, fax, website, business_structure, vat)
                        VALUES('$name', '$address', '$number', '$email', '$fax', '$website', '$type', '$vat')";
    $db->query($query);
    if ($query){
        header("location: http://".$_SERVER['HTTP_HOST']."/biztweak/smmeecosystemafrica/pay.php");
    }
}
?>