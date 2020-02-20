<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Account</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
	include_once 'header.php';
?>

<body class="bg fill">
	<div class="container fill">
		<h3 class="text-center"> Register Account </h3><hr>
		<div class="panel panel-default">
			<div class="panel-heading"> Account Information</div>
			<div class="panel-body">
				<form action="action/register.action.php" method="post">
					<div class="form-group col-md-12">
						<div class="form-group row">
							<label>	First Name </label>
							<input class="form-control" type="text" name="first" placeholder="First Name">
						</div>
						<div class="form-group row">
							<label>	Last Name </label>
							<input class="form-control" type="text" name="last"  placeholder="Last Name">
						</div>
						<div class="form-group row">
							<label>	E-mail </label>
							<input class="form-control" type="email" name="email" placeholder="E-mail Address">
							<span class="form_error">
								<?php echo $_SESSION['email_error'];
											$_SESSION['email_error'] = "";
							 	?>
						 	</span>
						</div>
						<div class="form-group row">
							<label>	Username </label>
							<input class="form-control" type="text" name="username" placeholder="Username">
							<span class="form_error">
								<?php echo $_SESSION['username_error'];
											$_SESSION['username_error'] = "";
								 ?>
							</span>
						</div>
						<div class="form-group row">
							<label>	Password </label>
							<input class="form-control" type="password" name="password" placeholder="Password">
						</div>
						<div class="form-group row">
							<label>	Confirm Password </label>
							<input class="form-control" type="password" name="confirm" placeholder="Confirm Password">
							<span class="form_error">
								<?php echo $_SESSION['pass_error'];
											$_SESSION['pass_error'] = "";
							 	?>
							</span>
						</div>
						<div class="form-group row">
							<button class="btn btn-default" type="submit" name="register_submit">Submit</button>
							<span class="form_error">
								<?php echo $_SESSION['empty_error'];
											$_SESSION['empty_error'] = "";
								?>
							</span><br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php
	include_once 'footer.php';
?>
