<?php


  if(isset($_POST['logout_button']))
  {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
  }

 ?>
