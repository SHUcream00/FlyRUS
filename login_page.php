<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<?php
	include_once 'header.php';
?>

<body class="fill bg">
  <div class="container fill">
    <?php
      $error = strval($_GET['e']);
      if( $error == "not_logged_in")
      {
        echo '<br><h5 class="text-center"> Must be logged in to access this feature.</h5><br>';
      }
    ?>
		<div class="panel panel-default">
			<div class="panel-heading">Login</div>
			<div class="panel-body">
		    <form action="action/login.action.php" method="POST">
		          <div class="form-group col-md-6 col-md-offset-3">
								<h4 class"text-center">Please Login:</h4>
		            <input class="form-control" type="text" name="login_user" placeholder="Username">
		            <input class="form-control" type="password" name="login_password" placeholder="Password">
		            <button class="btn btn-default navbar-btn" type="submit" name="login_header_submit">Login</button>
								<div class="form-row">
								<a href="register.php" id="register">Register</a>
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
