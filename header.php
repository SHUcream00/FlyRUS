		<header>

			<nav class="navbar navbar-expand-lg">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">Fly's R Us</a>
					</div>
 					<ul class ="nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="search_flight.php">Flight Status</a></li>
						<li><a href="information.php">Travel Information</a></li>
						<li><a href="book_flight_search.php">Book Flight</a></li>
						<li><a href="check_in.php">Check In</a></li>
						<li><a href="contact_support.php">Contact Support</a></li>
						<li><a href="about.php">Help / About</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
					<?php
						session_start();
						if(isset($_SESSION['user_id']))
						{
							echo
							 ' <li><a href="user_account_page.php">' . 'Welcome, ' . $_SESSION['user_fname'] . '</a></li>
							 	 <li><a href="user_account_page.php"><span class="glyphicon glyphicon-user"></span></a></li>
							 	 <li><form class="form-inline" action="action/logout.action.php" method="POST">
								 	<div class="form-group mb-1">
										<span class="glyphicon glyphicon-log-out"></span>
									</div>
									<button type="submit" class="btn btn-default navbar-btn" name="logout_button">Log Out</button>
								</form></li>';
						}
						else
						{
							echo '<li><span class="navbar-text" id="login_error">' . $_SESSION['login_error']. '</span></li>
										<li><form  class="form-inline" action="action/login.action.php" method="POST">
							 		 				<div class="form-group">
														<input class="form-control" type="text" name="login_user" placeholder="Username">
														<input class="form-control" type="password" name="login_password" placeholder="Password">
														<button class="btn btn-default navbar-btn" type="submit" name="login_header_submit">Login</button>
													</div>
												</form></li>
										<li><a href="register.php" id="register">Register</a></li>';
										$_SESSION['login_error'] = "";
						}
						?>
					</ul>
				</div>
			</nav>
		</header>

		<style>

		.bg {
		background: url('airplane.jpg') no-repeat center center fixed;
		    -webkit-background-size: cover;
		    -moz-background-size: cover;
		    background-size: cover;
		    -o-background-size: cover;
		    height:100%;
		}

		.fill {
		border-radius: 10px;
    min-height: auto;
    height: 100%;
		}

		.panel, .panel-default
		{
			margin-top: 15px;
			margin-bottom: 15px;
			border-color: #AAA;
		}

		.panel > .panel-heading
		{
			background-image: none;
			background-color: #EEFCFF;
			/*color: #337ab7;*/
			color: black;
			border-color: #AAA;
			font-weight: bold;
		}


		header nav.navbar
		{
			background-color: #EEFCFF;
		}
	 	ul.nav a:hover { background-color: #CCEBF1 !important; }


		.btn-default
		{
			color: #464646;
			background-color: #EEFCFF;
			border-color: #AAA;
		}

		.btn-default:hover
		{
			color: #464646;
			background-color: #CCEBF1;
		}

		.container
		{
			background-color: #fff;
			width: 60%;
			border-color: #AAA;
			padding-bottom: 15px;
		}
		body
		{
				margin-bottom: 45px;
		}

		.footer {
		padding-top: 5px;
		color: #AAA;
		margin-top: 15px;
    position: fixed;
    height: 30px;
    bottom: 0;
		left:0;
    width: 100%;
		background-color: #CCEBF1;
		}

		.jumbotron
		{
			color: #EEFCFF;
			background-color: rgba(5, 10, 17, 0.3);
			border-radius: 5px;
			width: 100%;
			left: 0;
			padding-top: 15px;
			padding-left: 15px;
			height: 100vh;

		}



		</style>
