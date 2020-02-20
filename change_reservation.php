<?php
	include_once 'check_login.php';
?>


<?php
//$_SESSION['from_flight_search'] = true;
$conn = mysqli_connect("localhost", "root", "362proj", "geekwaredb");
$output = '';
$confirmation_num = intval($_GET['Confirmation_Number']);
$_SESSION['confirmation_num'] = $confirmation_num;
$flightid = intval($_GET['Flight_ID']);
$sql = "SELECT * FROM reserveflight WHERE Flight_ID=$flightid, Payment_ID=$confirmation_num";
$sql_update = "SELECT * FROM allflights WHERE Flight_ID=$flightid";

$query = mysqli_query($conn, $sql);

$query_update = mysqli_query($conn, $sql_update);

while($row_update = mysqli_fetch_array($query_update)) {
	$source = $row_update['Flight_source'];
	$destination = $row_update['Flight_destination'];
}

if(isset($_POST['search_date'])){

	$search_departure_date = mysqli_real_escape_string($conn, $_POST['search_date']);
	$sql = "SELECT * FROM allflights WHERE Flight_destination='{$_SESSION['fid_destination']}' AND Flight_source='{$_SESSION['fid_source']}' AND Departure_date='$search_departure_date' ";
	$query = mysqli_query($conn, $sql) or die("Could not search");
	$count = mysqli_num_rows($query);
	if($count == 0){
		$output = 'There was no flights for your search.';
	}
	else {
		$output .=
		'<div class="panel-heading">Results</div>
		<div class="panel-body">
		<table class="table">
			<thead>
				<th>From</th>
				<th>Departure Time</th>
				<th>Departure Date</th>
				<th>To</th>
				<th>Arrival Time</th>
				<th>Arrival Date</th>
			</thead> <tbody>';

		while($row = mysqli_fetch_array($query)) {
			$source = $row['Flight_source'];
			$destination = $row['Flight_destination'];
			$d_date = $row['Departure_date'];
			$a_date = $row['Arrival_date'];
			$a_time = $row['Arrival_time'];
			$d_time = $row['Departure_time'];
			$updated_flight_id = $row['Flight_ID'];


			$output .= '<tr> <td>'.$source.'</td><td>'.$d_time.'</td><td>'.$d_date.'</td><td>'.$destination.'</td><td>'.$a_time.'</td><td>'.$a_date.
			'</td><td><a href="confirm_change_seat.php?Confirmation_Number='.$confirmation_num.'&Flight_ID='.$updated_flight_id.'&Email='.$_SESSION['user_email'].'">Update</a></td></tr>';
		}
		$output .= '</tbody></div>';
	}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Book Flight</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<?php
 include_once 'header.php';
$conn = mysqli_connect("localhost", "root", "362proj", "geekwaredb");
 $url_fid = intval($_GET['Flight_ID']);
 $fid_query = "SELECT * FROM allflights WHERE Flight_ID=$flightid";
 $fid_results = mysqli_query($conn, $fid_query);
 if($fid_row = mysqli_fetch_array($fid_results))
 {
	 $_SESSION['fid_source'] = $fid_row['Flight_source'];
	 $_SESSION['fid_destination'] = $fid_row['Flight_destination'];
 }
 $conn->close();
?>

<body class="bg fill">
	<div class="container fill">
		<h3 class="text-center">Change Flight Date</h3><hr>
		<div class="panel panel-default">
			<div class="panel-heading">Flight search</div>
			<div class="panel-body">
		<form action="change_reservation.php?Flight_ID=<?php echo $_GET['Flight_ID']?>&Confirmation_Number=<?php echo $_GET['Confirmation_Number'] ?>" method="post">
				<div class="form-group">
				</div>
					<div class="form-group col-md-6">
						<label for="search_source">From</label>
						<input class="form-control" name="search_source" value="<?php echo $_SESSION['fid_source']?>"/ disabled>
					</div>
					<div class="form-group col-md-6">
						<label for="search_desitnation">To</label>
						<input class="form-control" name="search_destination" value="<?php echo $_SESSION['fid_destination']?>"/ disabled>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="start">Start Date</label>
						<input class="form-control" type="date" name="search_date">
					</div>
					<div class="form-group row">
						<div class="col-md-10">
							<button type="submit" class="btn btn-default">Search</button>
						</div>
					</div>
		</form>
	</div>
	</div>
	<div class="panel panel-default">
		<?php print("$output");?>
	</div>
</div>

<footer class="footer">

</footer>

</body>


<?php
	include_once 'footer.php';
?>
