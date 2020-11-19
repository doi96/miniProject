<?php 
    //get access code
    $access_code = isset($_GET['access_code']) ? $_GET['access_code'] : die('ERRO: access code not found!');
    // echo $access_code;die; 

    //connect data and class
    include_once 'config/Database.php';
    $database = new Database();
    $db = $database->getConnection();

    include_once 'Controller/User.php';
    $user = new User($db);
    $user->access_code = $access_code;

    //check exists acccount with access code
    if(!$user->checkExistAccount()){
    echo "Sorry! Your access code is not found, please try again.";

    }else{
    // echo "true";
    header("Location: {$home_url}login.php?action=email_verified");
    }
?>