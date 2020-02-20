<?php
	include_once 'check_login.php';
?>

 <!DOCTYPE html>
 <html lang="en">

	 <head>
		 <meta charset="utf-8">
		 <meta http-equiv="X-UA-Compatible" content="IE=edge">
		 <meta name="viewport" content="width=device-width, initial-scale=1">
		 <title>Travel Details</title>
		 <link href="css/bootstrap.min.css" rel="stylesheet">
		 <link href="css/styleB.css" rel="stylesheet" type="text/css">
	 </head>

<?php include_once 'header.php' ?>

<body class="bg fill">
<div class="container fill">
<?php
include_once 'action/db_connect.php';
$updated_flightid = $_SESSION['book_flight_id'];
$confirmation_num = $_SESSION['confirmation_num'];
$updated_seatid = $_SESSION['updated_seatid'];

//if(!$query){
//	die(mysqli_error($sql_edit));
//}

include_once 'update_seat_struct.php';
$uid = $_SESSION['user_id'];

$result = mysqli_query($db_conn, "SELECT * FROM ReserveFlight WHERE (ReserveFlight.User_ID = $uid AND ReserveFlight.Payment_ID = $confirmation_num)");
$prev_row = $result->fetch_array();
$old_sid = $prev_row['Flight_seat'];
$old_fid = $prev_row['Flight_ID'];

$sql_edit = "UPDATE ReserveFlight SET ReserveFlight.Flight_ID = $updated_flightid, ReserveFlight.Flight_seat = '$updated_seatid' WHERE ReserveFlight.Payment_ID=$confirmation_num";
$query = mysqli_query($db_conn, $sql_edit);
if($query) {
	$update_checkin = "UPDATE CheckIn SET CheckIn.Flight_ID = $updated_flightid WHERE CheckIn.Payment_ID=$confirmation_num";
	mysqli_query($db_conn, $update_checkin);
	update_seat_struct(true, $old_fid, $old_sid);
	update_seat_struct(false, $updated_flightid, $updated_seatid);
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require_once('vendor/autoload.php');
//$email = $_POST['email'];

$email = strval($_GET['Email']);

$sql = "SELECT Email FROM UserAcct WHERE Email='$email'";
if($_GET) {
	$email = strval($_GET['Email']);

	$result = mysqli_query($db_conn, $sql);
	$count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
	if($count > 0) {
		$link="<a href='http://localhost/CSUF-CPSC-362/contact_support.php?email=$email'>Contact Us</a>";

		$mail = new PHPMailer(true);
		try{
			//server settings
			 //$mail->SMTPDebug = 1; // Enable verbose debug output
		  $mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = 'tls://smtp.gmail.com';
			$mail->Username = 'flysrus.geekware@gmail.com';
			$mail->Password = 'randompass123';
			$mail->SMTPSecure ='tls';
			$mail->Port = 587;
			//recipients
			$mail->setFrom('flysrus.geekware@gmail.com', 'Flys R US Booking');
			$mail->addAddress($email);
			//content
			$mail->isHTML(true); // Set email format to HTML
			$mail->Subject = "Update Reservation";
			$mail->Body = "<br/>Recently a request was submitted update a reservation.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->AltBody = "<br/>Recently a request was submitted update a reservation.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->send();
			echo '<br><h3 class="text-center">A confirmation email was sent for your reservation change. You will be automatically redirected in 5 seconds</h3>';
		}
		catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}
	else {
		echo 'Email not found, please enter another one or visit contact page';
	}
}
$db_conn->close();
header("refresh:5;url=print_itinerary.php");
?>

</div>
</body>

<?php
	include_once 'footer.php';
?>
