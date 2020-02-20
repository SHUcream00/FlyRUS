<?php
include_once 'check_login.php';
//only allow access if user is redirected here by previous booking page
if (!(isset($_SESSION['from_select_seat'])) or $_SESSION['from_select_seat'] == false) {
	header('Location: index.php?error=no_access');
	exit();
}
else {
  $_SESSION['from_select_seat'] = false;
}

$_SESSION['from_payment'] = true;
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
	include_once 'header.php';
?>


<style>
th, td {
    padding: 5px;
}
th {
    text-align: left;
}
</style>

<body class="bg fill">
<div class="container fill">
<h3 class="text-center">Payment</h3><hr>
<div class="panel panel-default">
<div class="panel-heading"> Input Payment Information </div>
<div class="panel-body">
<form method = "post" action = "confirm_payment.php">
<table class="table">
<tr><th>Card Number : </th><th colspan="2"><input type = "text" name = "card_number"></th></tr>
<tr><th>CVV : </th><th colspan="2"><input type = "text" name = "cvv"></th></tr>
<tr><th>Expiration Date : </th><th colspan="2">
<select name = "exp_m">

<?php
for($i = 1; $i <= 12; $i++) {
	echo "<option value = ".$i.">".$i;
}
?>

</select> /
<select name = "exp_y"

<?php
for($j = 18; $j <= 36; $j++) {
	echo "<option value = ".$j.">".$j;
}
?>

</select>
</th></tr>
</table>
<button class="btn btn-default" type="submit" name="payment_submit">Submit</button>
</form>
</div>
</div>
</div>
</body>

<?php
	include_once 'footer.php';
?>
