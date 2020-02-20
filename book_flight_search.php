<?php

include_once 'check_login.php';

$_SESSION['from_flight_search'] = true;

$conn = mysqli_connect("localhost", "root", "362proj", "geekwaredb");
$output = '';
if(isset($_POST['search_destination'], $_POST['search_source'], $_POST['search_date'])){
	//add code here to disallow months with less than 31 days from having day value > 30... and Feb.
	$search_to = mysqli_real_escape_string($conn, $_POST['search_destination']);
	$search_from = mysqli_real_escape_string($conn, $_POST['search_source']);
	$search_departure_date = mysqli_real_escape_string($conn, $_POST['search_date']);
	$sql = "SELECT * FROM allflights WHERE Flight_destination = '$search_to' AND Flight_source = '$search_from' AND Departure_date = '$search_departure_date'";
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
			$flight_id = $row['Flight_ID'];


			$output .= '<tr> <td>'.$source.'</td><td>'.$d_time.'</td><td>'.$d_date.'</td><td>'.$destination.'</td><td>'.$a_time.'</td><td>'.$a_date.
			'</td><td><a href="book_flight.php?fid=' .$flight_id. '">Book</a></td></tr>';
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
?>

<body class="bg fill">
	<div class="container fill">
		<h3 class="text-center">Book Flight</h3><hr>
		<div class="panel panel-default">
			<div class="panel-heading">Flight search</div>
			<div class="panel-body">
			<form action="book_flight_search.php" method="post">
					<div class="form-group">
					</div>
						<div class="form-group col-md-6">
							<label for="search_source">From</label>
							<select class="form-control" name="search_source">
								<option value="Orange County">Orange County - SNA</option>
								<option value="Los Angeles">Los Angeles - LAX</option>
								<option value="London">London - LHR</option>
								<option value="New York">New York - JFK</option>
								<option value="Tokyo">Tokyo - NRT</option>
								<option value="Paris">Paris - CDG</option>
								<option value="Dubai">Dubai - DXB</option>
								<option value="New Delhi">New Delhi - DEL</option>
								<option value="Beijing">Beijing - PEK</option>
								<option value="Rome">Rome - FCO</option>

							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="search_desitnation">To</label>
							<select class="form-control" name="search_destination">
								<option value="Orange County">Orange County - SNA</option>
								<option value="Los Angeles">Los Angeles - LAX</option>
								<option value="London">London - LHR</option>
								<option value="New York">New York - JFK</option>
								<option value="Tokyo">Tokyo - NRT</option>
								<option value="Paris">Paris - CDG</option>
								<option value="Dubai">Dubai - DXB</option>
								<option value="New Delhi">New Delhi - DEL</option>
								<option value="Beijing">Beijing - PEK</option>
								<option value="Rome">Rome - FCO</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="start">Start Date</label>
							<input class="form-control" type="date" name="search_date">
						</div>
						<div class="form-group row">
							<div class="col-md-10">
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
							</div>
							</div>
			</form>
			</div>
		</div>
		<div class="panel panel-default">
		<?php print("$output");?>
		</div>
	</div>
</body>

<?php
include_once 'footer.php';
?>
