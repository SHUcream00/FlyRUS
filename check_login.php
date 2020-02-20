<?php
session_start();
if(!isset($_SESSION['user_id'])) {
  header('Location: login_page.php?e=not_logged_in');
  exit();
}
 ?>
