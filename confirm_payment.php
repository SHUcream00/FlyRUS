<?php
include_once 'check_login.php';
//only allow access if user is redirected here by previous booking page
if (!(isset($_SESSION['from_payment'])) or $_SESSION['from_payment'] == false) {
  header('Location: index.php?error=no_access');
  exit();
}
else {
  $_SESSION['from_payment'] = false;
}
//get post from payment.php
if(isset($_POST['payment_submit']))
{
include_once 'action/db_connect.php';
include_once 'update_seat_struct.php';

//  $payment_sql = $db_conn->prepare("INSERT INTO payment (User_ID, Credit_card_num, Credit_card_exp_date, Credit_card_cvv) VALUES ( ?, ?, ?, ?)");

  if(empty($_POST['card_number']) || empty($_POST['cvv']) || empty($_POST['exp_m']) || empty($_POST['exp_y']))
  {
    $_SESSION['from_select_seat'] = true;
    header('Location: payment.php?e=empty');
  }
  else
  {
    $ccnum = mysqli_real_escape_string($db_conn, $_POST['card_number']);
    $cvv = mysqli_real_escape_string($db_conn, $_POST['cvv']);
    $exp_m = mysqli_real_escape_string($db_conn, $_POST['exp_m']);
    $exp_y = mysqli_real_escape_string($db_conn, $_POST['exp_y']);
    $get_date = mktime(0,0,0, $exp_m, 1, $exp_y);
    $exp_date = date("Y-m-d", $get_date);
	$uid = $_SESSION['user_id'];
	$sid = $_SESSION['seatID'];
	$fid = $_SESSION['book_flight_id'];
    $bag_init = 0;

$result = mysqli_query($db_conn, "SELECT * FROM ReserveFlight WHERE (ReserveFlight.User_ID = $uid AND ReserveFlight.Flight_ID = $fid)");
	if ($prev_row = $result->fetch_array()) {
		$old_sid = $prev_row['Flight_seat'];
		mysqli_query($db_conn, "DELETE FROM CheckIn WHERE (CheckIn.User_ID = $uid AND CheckIn.Flight_ID = $fid)");
		mysqli_query($db_conn, "DELETE FROM ReserveFlight WHERE (ReserveFlight.User_ID = $uid AND ReserveFlight.Flight_ID = $fid)");
		update_seat_struct(true, $fid, $old_sid);
	}
	mysqli_query($db_conn, "INSERT INTO Payment (User_ID, Credit_card_num, Credit_card_exp_date, Credit_card_cvv) VALUES ('$uid', '$ccnum', '$exp_date', '$cvv')");
	$last_id = mysqli_insert_id( $db_conn );
    mysqli_query($db_conn, "INSERT INTO ReserveFlight (Flight_ID, Flight_seat, Num_of_bags, User_ID, Payment_ID) VALUES ('$fid', '$sid', '$bag_init', '$uid', '$last_id')");
	#mysqli_query($db_conn, "INSERT INTO CheckIn (Confirmation_Num, Flight_ID, Check_In_Status, User_ID, Luggages) VALUES ('$last_id', '$fid', 'Not Checked in', '$uid', '$bag_init')");

//updates seat_struct in the sql to claim seat
	update_seat_struct(false, $fid, $sid);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment Confirmation</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<?php
	include_once 'header.php';
?>

<body class="bg fill">
<div class="container fill">
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require_once('vendor/autoload.php');
//$email = $_POST['email'];

$email = strval($_SESSION['user_email']);

$sql = "SELECT Email FROM UserAcct WHERE Email='$email'";
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
			$mail->Subject = "Flight Reservation";
			$mail->Body = "<br/>Recently a flight reservation was submitted.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->AltBody = "<br/>Recently a flight reservation was submitted.
			If you did not sumbit a request please $link by clicking the link.";
			$mail->send();
				echo '<br><h3 class="text-center">A confirmation email was sent for your reservation. You will be automatically redirected in 5 seconds</h3>';
		}
		catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}
	else {
		echo 'Email not found, please enter another one or visit contact page';
	}

$db_conn->close();
header("refresh:5;url=index.php");
?>
</div>
</body>

<?php
	include_once 'footer.php';
?>
