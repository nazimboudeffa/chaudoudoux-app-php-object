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
  <?php
    if (!isset($_SESSION['username'])){
      echo "You are not connected";
    } else {
      include 'forms/settings.php';
    }
  ?>

</body>
</html>
