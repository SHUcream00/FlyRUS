<?php 
	include_once 'check_login.php';

	include_once 'header.php';
?>
<?php
$updated_flightid = intval($_GET['Flight_ID']);
$_SESSION['book_flight_id'] = $updated_flightid;
$_SESSION['from_change_reservation'] = true;
header('Location: seat_select.php');
exit()
?>
<?php
	include_once 'footer.php';
?>