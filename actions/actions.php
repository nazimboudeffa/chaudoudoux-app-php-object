<?php

session_start();
include '../config/connect.php';

$action = filter_var(htmlentities($_POST['action']),FILTER_SANITIZE_STRING);

switch ($action) {
//
  case 'login_forgotten' :

    $forgotten_email = filter_var(htmlentities($_POST['email']),FILTER_SANITIZE_STRING);
    $eemsql = "SELECT * FROM users WHERE email=:forgotten_email";
    $exist_email = $con->prepare($eemsql);
    $exist_email->bindParam(':forgotten_email', $forgotten_email, PDO::PARAM_STR);
    $exist_email->execute();

    $error = false;

    $num_em_ex = $exist_email->rowCount();
    if ($num_em_ex == 0){
      $error = true;
    }else{
      //SEND EMAIL WITH NEW PASSWORD
    }

    $array = array(
      'error'=>$error
    );
    $json = json_encode($array);
    echo $json;

  break;
//
  case 'check' :

    $signup_username = filter_var(htmlentities($_POST['username']),FILTER_SANITIZE_STRING);
    $signup_email = filter_var(htmlentities($_POST['email']),FILTER_SANITIZE_STRING);

    $eunsql = "SELECT * FROM cdd_users WHERE username=:signup_username";
    $exist_username = $con->prepare($eunsql);
    $exist_username->bindParam(':signup_username', $signup_username, PDO::PARAM_STR);
    $exist_username->execute();

    $eemsql = "SELECT * FROM cdd_users WHERE email=:signup_email";
    $exist_email = $con->prepare($eemsql);
    $exist_email->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
    $exist_email->execute();

    $num_un_ex = $exist_username->rowCount();
    $num_em_ex = $exist_email->rowCount();

    $error = false;

    if ($num_un_ex == 1){$error = true;}

    if ($num_em_ex == 1){$error = true;}

    $array = array(
      'error'=>$error
    );
    $json = json_encode($array);
    echo $json;

  break;
//
  case 'register' :

    $signup_id = (rand(0,99999).time()) + time();
    $signup_username = filter_var(htmlentities($_POST['rusername']),FILTER_SANITIZE_STRING);
    $signup_email = filter_var(htmlentities($_POST['remail']),FILTER_SANITIZE_STRING);
    $signup_password_var = filter_var(htmlentities($_POST['rpassword']),FILTER_SANITIZE_STRING);
    $options = array(
        'cost' => 12,
    );
    $signup_password = password_hash($signup_password_var, PASSWORD_BCRYPT, $options);

    $signupsql = "INSERT INTO cdd_users (id, username, email, password) VALUES (:signup_id, :signup_username, :signup_email, :signup_password)";
    $query = $con->prepare($signupsql);
    $query->bindParam(':signup_id', $signup_id, PDO::PARAM_INT);
    $query->bindParam(':signup_username', $signup_username, PDO::PARAM_STR);
    $query->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
    $query->bindParam(':signup_password', $signup_password, PDO::PARAM_STR);
    $query->execute();

    // ========================== login code after signup ============================
    $loginsql = "SELECT * FROM cdd_users WHERE email= :signup_email AND password= :signup_password";
    $query = $con->prepare($loginsql);
    $query->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
    $query->bindParam(':signup_password', $signup_password, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();

    $error = false;

    if($num == 0){
      $error = true;
    }else{
      include ("../includes/login-fetch.php");
    }

    $array = array(
      'error'=>$error
    );
    $json = json_encode($array);
    echo $json;

  break;
//
  case 'login' :

    $email = htmlentities($_POST['lemail'], FILTER_SANITIZE_STRING);
    $password = filter_var(htmlentities($_POST['lpassword']),FILTER_SANITIZE_STRING);

    $loginsql = "SELECT * FROM cdd_users WHERE email= :email";
    $query = $con->prepare($loginsql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();

    $error = false;

    if($num == 0){
      $error = true;
    }else{
      include ("../includes/login-fetch.php");
    }

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $verif_password = $row['password'];
      if(!password_verify($password,$verif_password)){
        $error = true;
      }else{
        include ("../includes/login-fetch.php");
      }
    }

    $array = array(
      'error'=>$error
    );
    $json = json_encode($array);
    echo $json;

  break;
}

?>
