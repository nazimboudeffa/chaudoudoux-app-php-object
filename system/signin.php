<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <?php include 'includes/head.php' ?>
    <script src="libs/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="libs/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="libs/css/validationEngine.jquery.css" type="text/css"/>
    
  </head>
  <body>

    <?php include 'includes/header.php' ?>

    <script src="js/login.js"></script>
    <script src="js/script.js"></script>

    <?php
      if (isset($_SESSION['username'])){
        echo "You are connected";
      } else {
        include 'forms/login.php';
      }
    ?>
  </body>
</html>
