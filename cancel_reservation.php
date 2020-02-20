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

<?php
	 include_once 'header.php';
 ?>

<body class="bg fill">
<div class="container fill">
<?php
include_once 'action/db_connect.php';
include_once 'update_seat_struct.php';
$flight_id = intval($_GET['Flight_ID']);
$uid = $_SESSION['user_id'];
$result = mysqli_query($db_conn, "SELECT * FROM ReserveFlight WHERE (ReserveFlight.User_ID = $uid AND ReserveFlight.Flight_ID = $flight_id)");
	if ($prev_row = $result->fetch_array()) {
		$sid = $prev_row['Flight_seat'];
		mysqli_query($db_conn, "DELETE FROM CheckIn WHERE (CheckIn.User_ID = $uid AND CheckIn.Flight_ID = $flight_id)");
		mysqli_query($db_conn, "DELETE FROM ReserveFlight WHERE (ReserveFlight.User_ID = $uid AND ReserveFlight.Flight_ID = $flight_id)");
		update_seat_struct(true, $flight_id, $sid);
	}

	else {
		die('Could not delete data.');
	}
$db_conn->close();
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require_once('vendor/autoload.php');
//$email = $_POST['email'];

$conn = mysqli_connect("localhost", "root", "362proj", "geekwaredb");
$email = strval($_GET['Email']);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sql = "SELECT Email FROM UserAcct WHERE Email='$email'";
if($_GET) {
	$email = strval($_GET['Email']);

	$result = mysqli_query($conn, $sql);
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
			$mail->Subject = "Reservation Cancellation";
			$mail->Body = "<br/>Recently a request was submitted cancel a reservation.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->AltBody = "<br/>Recently a request was submitted cancel a reservation.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->send();
				echo '<br><h3 class="text-center">A confirmation email was sent for your cancelation. You will be automatically redirected in 5 seconds</h3>';
		}
		catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}
	else {
		echo 'Email not found, please enter another one or visit contact page';
	}
}
$conn->close();
header("refresh:5;url=print_itinerary.php");
?>
</div>
</body>

<?php
	include_once 'footer.php';
?>
