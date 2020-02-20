<?php
include_once 'check_login.php';
//only allow access if user is redirected here by previous booking page
if ((!isset($_SESSION['from_flight_search'])) or $_SESSION['from_flight_search'] == false) {
	header('Location: index.php?error=no_access');
	exit();
}
else {
  $_SESSION['from_flight_search'] = false;
}


$_SESSION['from_book_flight'] = true;
$_SESSION['book_flight_id'] = intval($_GET['fid']);

include_once 'seat_select.php';

?>
