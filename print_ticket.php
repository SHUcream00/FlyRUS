<?php
	include_once 'check_login.php';
?>
<?php
$conn = mysqli_connect("localhost", "root", "362proj", "geekwaredb");
$output = '';
$flightid = intval($_GET['Flight_ID']);
$confirmationnum = intval($_GET['Confirmation_Number']);
$sql = "SELECT * FROM reserveflight WHERE Flight_ID=$flightid, Payment_ID=$confirmationnum";
$sql_allflights = "SELECT * FROM allflights WHERE Flight_ID=$flightid";
$sql_reserveflight = "SELECT * FROM reserveflight WHERE Payment_ID=$confirmationnum";

$query = mysqli_query($conn, $sql);
$query_allflights = mysqli_query($conn, $sql_allflights);
while($row_allflights = mysqli_fetch_array($query_allflights)) {
	$source = $row_allflights['Flight_source'];
	$destination = $row_allflights['Flight_destination'];
	$destinationcode = $row_allflights['Destination_code'];
	$sourcecode = $row_allflights['Source_code'];
	$departtime = $row_allflights['Departure_time'];
	$arrivaltime = $row_allflights['Arrival_time'];
	$departdate = $row_allflights['Departure_date'];
	$arrivaldate = $row_allflights['Arrival_date'];
	$gate = $row_allflights['Flight_gate'];
}
$query_reserveflight = mysqli_query($conn, $sql_reserveflight);
while($reserveflight = mysqli_fetch_array($query_reserveflight)) {
	$seat = $reserveflight['Flight_seat'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Ticket</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="js/jspdf.min.js"></script>
	<script type="text/javascript" src="js/html2canvas.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
	<script>
	function genPDF() {
		html2canvas(document.getElementById("printticket"), {
			onrendered: function(canvas) {
				var img = canvas.toDataURL("image/png");
				var doc = new jsPDF();
				doc.addImage(img, 'JPEG', 20, 20);
				doc.save('Fly\'s R US Itinerary.pdf');
			}
		});
	}
	</script>
</head>
<body>
<div id="printticket">
<link rel="stylesheet" type="text/css" href="css/boarding_pass.css">
	<div id="demo">
		<div class="ticket">
			<header>
				<div class="company-name">Fly's R US</div>
				<div class="customer-name"><?php echo $_SESSION["user_fname"];?> <?php echo $_SESSION["user_lname"];?></div>
				<div class="terminal-name">Terminal 2</div>
				<div class="departure-name">Departure Date:</div>
				<div class="departure-date"><?php echo $departdate ?></div>
				<div class="logo">
					<img src="images/logo.png" />
				</div>
			</header>
			<section class="airports">
				<div class="airport">
					<div class="airport-name"><?php echo $source ?></div>
					<div class="airport-code"><?php echo $sourcecode ?></div>
					<div class="dep-arr-label">Departing</div>
					<div class="time"><?php echo $departtime ?></div>
				</div>
				<div class="airport">
					<div class="airport-name"><?php echo $destination ?></div>
					<div class="airport-code"><?php echo $destinationcode ?></div>
					<div class="dep-arr-label">Arriving</div>
					<div class="time"><?php echo $arrivaltime ?></div>
				</div>
				<div class="airport">
					<div class="place-block">
						<div class="place-label">Gate</div>
						<div class="place-value"><?php echo $gate ?></div>
					</div>
					<div class="place-block">
						<div class="place-label">Seat</div>
						<div class="place-value"><?php echo $seat ?></div>
					</div>
					<div class="place-block">
						<div class="place-label">Flight</div>
						<div class="place-value"><?php echo $flightid ?></div>
					</div>
				</div>
			</section>
			<section class="barcode">
				<div class="qr">
					<img src="images/barcode1.png" />
					<img src="images/barcode2.png" />
				</div>
			</section>
		</div>
	</div>
	<div class="container">
		<hr style="
			width:45%; 
			margin:0; 
			border: 0 none; 
			border-top: 2px dashed #000; 
			background: none; 
			height:0px; 
			margin-top: 5px;"
		>
		<h3 align="left" style="color:black;">Itinerary</h3>
		<hr style="
			width:45%; 
			margin:0; 
			border: 0 none; 
			border-top: 1px solid #148fd2; 
			background: none; 
			height:0px; 
			margin-top: 10px;"
		>
	</div>
	<div class="print-itinerary">
		<table>
			<tbody>
				<tr>
					<th style="text-align: left;">Name: </th>
					<td><?php echo $_SESSION["user_fname"];?> <?php echo $_SESSION["user_lname"];?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Confirmation Number: </th>
					<td><?php echo $confirmationnum ?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Flight ID: </th>
					<td><?php echo $flightid ?></td>
					</tr>
				<tr>
					<th style="text-align: left;">Departure Source: </th>
					<td><?php echo $source ?> - <?php echo $sourcecode ?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Arrivial Destination: </th>
					<td><?php echo $destination ?> - <?php echo $destinationcode ?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Departure Date/Time: </th>
					<td><?php echo $departdate ?> @ <?php echo $departtime ?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Arrivial Time: </th>
					<td><?php echo $arrivaldate ?> @ <?php echo $arrivaltime ?></td>
				</tr>
				<tr>
					<th style="text-align: left;">Gate: </th>
					<td><?php echo $gate ?></td>
				</tr>
				<tr>
				<th style="text-align: left;">Seat: </th>
				<td><?php echo $seat ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</body>
<style>
button {
	
	background-color: #4CAF50;
    border: none;
    color: white;
    padding: 12px 30px;
    cursor: pointer;
    font-size: 20px;
	border-radius: 5px;
	border: 2px solid #4CAF50;
}
button:hover{
	background-color: White;
}
a {
	color: #000;
	text-decoration: none;
}

</style>
<button class = "button-style">
	<a href="javascript:genPDF()">Print</a></button>
