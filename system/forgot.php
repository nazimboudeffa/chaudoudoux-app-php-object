<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'includes/head.php' ?>
  </head>
  <body>

    <?php include 'includes/header.php' ?>

    <script src="js/login.js"></script>

    <?php
      if (isset($_SESSION['username'])){
        echo "You are connected";
      } else {
        include 'forms/forgot.php';
      }
    ?>
  </body>
</html>
