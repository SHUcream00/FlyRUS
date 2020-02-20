<?php
include_once 'check_login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Account</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<?php
include_once 'header.php';
?>

<body class="bg fill">
	<div class="container fill">
	<style>
	table {
	border-collapse: collapse;
	width: 100%;
	}
	th, td {
		padding: 8px;
		text-align: left;
		border-bottom: 1px solid #000000;
	}
	th{
		padding: 8px;
		text-align: left;
		border-bottom: 2px solid #000000;
		background-color: #dddddd
	}
	</style>
		<h4 align="left" style="color:blue;">Review Travel Details</h4>
		<hr style="width:100% border: 0 none; border-top: 1px dashed #dddddd; background: none; height:0;">
		<h6 align="left" style="color:black;">View flight information below.</h6>
		<h6 align="left" style="color:black; background-color:#dddddd; padding: 10px; font-weight: bold;">Current Itinerary</h6>
		<div class="travel-details" style="border:1px solid #0000FF; padding: 10px">
		<table class="table-travel-details">
			<tr>
				<th>Flight</th>
				<th>Departs</th>
				<th>Arrives</th>
				<th>Flight Status</th>
				<th>Print Ticket</th>
				<th>Modify</th>
			</tr>
			<?php
				$db_server_name = "localhost";
				$db_user_name   = "root";
				$db_pass        = "362proj";
				$db_name        = "geekwaredb";

				$db_conn = new mysqli($db_server_name, $db_user_name, $db_pass, $db_name);
				if($db_conn->connect_error){
					die("Failed to connect to database: " . $db_conn->connect_error);
				}
				$session_id = $_SESSION['user_id'];
				$sql = "SELECT * FROM reserveflight WHERE User_ID='$session_id'
				";
				//$email_sql = "SELECT * FORM useracct WHERE Email='$session_email'";
				$result = $db_conn->query($sql);
				//$non_zero_result = false;
				while($row = $result->fetch_assoc())
				{
					//$non_zero_result = true;
					$row_id = $row['Flight_ID'];
					$flight_sql = "SELECT * FROM allflights WHERE Flight_ID='$row_id'";
					$flight_result = $db_conn->query($flight_sql);
					$f_row = $flight_result->fetch_assoc();
					echo '<tbody><tr>' .
						'<td style="text-align: left;"><div>'.$f_row["Flight_ID"].'<div></td>' .
						'<td style="text-align: left;"><div>'.$f_row["Flight_source"].'</div> <div>'.$f_row["Source_code"].'</div> <div>'.$f_row["Departure_date"].'</div> <div>'.$f_row["Departure_time"].'</div> </td>' .
						'<td style="text-align: left;"><div>'.$f_row["Flight_destination"].'</div> <div>'.$f_row["Destination_code"].'</div> <div>'.$f_row["Arrival_date"].'</div> <div>'.$f_row["Arrival_time"].'</div> </td>' .
						'<td><div>'.$f_row["Flight_status"].'</div></td>' .
						'<td>
							<a class="btn btn-default"
							href="print_ticket.php?Flight_ID='.$row["Flight_ID"].'&Confirmation_Number='.$row["Payment_ID"].'">Print</a>
						</td>' .
						'<td>
							<div>
								<a class="btn btn-default"
								href="change_reservation.php?Flight_ID='.$row["Flight_ID"].'&Confirmation_Number='.$row["Payment_ID"].'">Change</a>
							</div>
							</div>
							<div>
								<a class="btn btn-default"
								href="cancel_reservation.php?Flight_ID='.$row["Flight_ID"].'&Email='.$_SESSION['user_email'].'"
								onclick="return confirm(\'Are you sure you want to cancel this reservation?\')">Cancel</a>
							</div>
						</td>
					</tr></tbody>';
				}
				$db_conn->close();
			?>
		</table>
		</div>
	</div>
</body>


<?php
include_once 'footer.php';
?>
