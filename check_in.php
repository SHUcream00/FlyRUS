<?php
  include_once 'check_login.php';

   $servername = "localhost";
   $username = "root";
   $password = "362proj";
   $dbname = "geekwaredb";

   $conn = new mysqli($servername, $username, $password, $dbname);
   $result = "";
   $status = "";

   if(isset($_GET['luggageno'], $_GET['fid']))
   {
	   $luggages = mysqli_real_escape_string($conn, $_GET['luggageno']);
	   $flightid = mysqli_real_escape_string($conn, $_GET['fid']);
	   $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
	   $checkstatus = "Checked In";
	   $payment = mysqli_real_escape_string($conn, $_GET['pment']);

	   $sql = "INSERT INTO Checkin (Flight_ID, Check_In_Status, User_ID, Luggages, Confirmation_Num) VALUES ('$flightid', '$checkstatus', '$userid', '$luggages', '$payment')";

       if ($conn->query($sql) === TRUE)
       {
	  $confirmno = mysqli_query($conn, "SELECT * FROM CheckIn Where Flight_ID = '$flightid' AND User_ID = '$userid'")->fetch_assoc()['Confirmation_Num'];
          $confmsg .= "<h2>You've successfully Checked-in! Confirmation Number: ".$confirmno."</h2>";
       }
       else
       {
          $confmsg .= "Error: " . $sql . "<br>" . $conn->error;
       }
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Check In Flight</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<?php include_once 'header.php'; ?>

<body class="bg fill">
<div class="container fill">
<h3 class="text-center">Your Flights</h3>
<div class="panel panel-default">
<div class="panel-heading">Check In</div>
<div class="panel-body">
<form action="check_in.php" method="get">
		<table class="table">
			<thead>
				<th>Flight ID</th>
				<th>Departure Date</th>
				<th>Departure Time</th>
				<th>Check-In Status</th>
				<th>Number of Luggages</th>
			</thead> <tbody>
			<form action="check_in.php" method = "get">
			<?php
			      $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);

				  $sql =
				  "SELECT r.Flight_ID, r.User_ID, r.Payment_ID, a.Departure_date, a.Departure_time FROM ReserveFlight r
				  INNER JOIN AllFlights a ON r.Flight_ID = a.Flight_ID WHERE User_ID = '$userid'
				  AND TIMESTAMP(a.Departure_date, a.Departure_time) >= NOW()";
				  #$sql = "SELECT * FROM AllFlights";

				  $query = mysqli_query($conn, $sql);
				  $count = mysqli_num_rows($query);
				  if ($count == 0)
				  {
					  $result .= "<tr><td>You don't have any flight eligible for check in</td></tr>";
				  }
				  else
				  {
					  for ($i = 0; $i < $count; $i++)
					  {
						  $row = $query->fetch_assoc();
						  $check_existence = "SELECT * FROM CheckIn Where '".$row['Flight_ID']."'=  Flight_ID";
						  $query_existence = mysqli_query($conn, $check_existence);
						  if (mysqli_num_rows($query_existence) > 0)
						  {
							  $status = '<font color = "mediumAquamarine">Checked In</font>';
							  $result .= '<tr><td>'.$row['Flight_ID'].'</td><td>'.$row['Departure_date'].'</td><td>'.$row['Departure_time'].'</td><td><b>'.$status.
						  	  '</b></td><td>'.$query_existence->fetch_assoc()['Luggages'].
						  	  '</td></tr>';
						  }
						  else
						  {
							  $status = '<font color = "Red">Not Checked In</font>';
						 	  $result .= '<tr><td>'.$row['Flight_ID'].'</td><td>'.$row['Departure_date'].'</td><td>'.$row['Departure_time'].'</td><td><b>'.$status.
						  	  '</b></td><td><select class="form-group col-sm-3" name="luggageno"><option value="0">0</option><option value="1">1</option></select>'.
						  	  '</td><td><b><a href="check_in.php?luggageno='.rand(0,1).'&pment='.$row['Payment_ID'].'&fid=' .$row['Flight_ID']. '">Check In</a></b></td></tr>';
						  }


					  }
					  $result .= '</tbody>';
				  }

			?>

			</tbody>
			</form>

			<?php
				print("$result");
				if (isset($confmsg))
				{
					print("$confmsg");
				}
			?>
    </div>
  </div>
</div>
</body>

<?php include_once 'footer.php'; ?>
