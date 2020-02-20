<?php
  session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  if(isset($_POST['register_submit']))
  {
    include_once 'db_connect.php';

    $reg_stmt = $db_conn->prepare("INSERT INTO useracct (Username, PASSWORD, Email, First_name, Last_name, Flights) VALUES (?, ?, ?, ?, ?, '')");

    $_SESSION['username_error'] = $_SESSION['email_error'] = $_SESSION['pass_error'] = $_SESSION['empty_error'] = "";
    $form_fname = $form_lname = $form_user = $form_pass = "";
    $form_confirm = $form_email = "";
    $valid_user = $valid_email = $hashed_pass = "";

    $form_fname = mysqli_real_escape_string($db_conn, $_POST['first']);
    $form_lname = mysqli_real_escape_string($db_conn, $_POST['last']);
    $form_user = mysqli_real_escape_string($db_conn, $_POST['username']);
    $form_pass = mysqli_real_escape_string($db_conn, $_POST['password']);
    $form_confirm = mysqli_real_escape_string($db_conn, $_POST['confirm']);
    $form_email = mysqli_real_escape_string($db_conn, $_POST['email']);

    if(empty($form_fname) || empty($form_lname) || empty($form_user)
    || empty($form_pass) || empty($form_confirm) || empty($form_email))
    {
        $_SESSION['empty_error'] = "Fields cannot be empty.";
        header("Location: ../register.php?error=empty");
        exit();
    }
    else
    {
      //check if username already exists in database

      $user_query = "SELECT * FROM useracct WHERE Username='$form_user' ";
      $user_query_result = $db_conn->query($user_query);

      if(!$user_query_result->num_rows > 0)
      {
        $valid_user = $form_user;
      }
      else
      {
        $_SESSION['username_error'] = "Username already exists.";
        header("Location: ../register.php?username=error");
        exit();
      }

      //check if password and password confirmation match
      if($form_pass == $form_confirm)
      {
        $hashed_pass = password_hash($form_pass, PASSWORD_DEFAULT);
      }
      else
      {
        $_SESSION['pass_error'] = "Passwords do not match.";
        header("Location: ../register.php?password=error");
        exit();
      }

      //check if email valid
      if(filter_var($form_email, FILTER_VALIDATE_EMAIL) == false)
      {
          $_SESSION['email_error'] = "Email address not valid.";
          header("Location: ../register.php?email=error");
          exit();
      }
      else
      {
        $valid_email = $form_email;
      }

      //bind parameters and insert
      $reg_stmt->bind_param( "sssss", $valid_user, $hashed_pass, $valid_email, $form_fname, $form_lname);

      $reg_stmt->execute();


      //Load Composer's autoloader
      require_once('../vendor/autoload.php');
      //$email = $_POST['email'];

      $email = $valid_email;
  		$link="<a href='http://localhost/CSUF-CPSC-362/index.php?register=success'>click here to complete registration</a>";

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
  			$mail->Subject = "Account Registration";
  			$mail->Body = "<br/>This is an email confirmation for account $valid_user.
  			Please $link , or disregard this email if you did not submit this registration.";
  			$mail->AltBody = "<br/>This is an email confirmation for account $valid_user.
  			Please $link , or disregard this email if you did not submit this registration.";
  			$mail->send();
  				echo 'A confirmation email was sent to your email. Please follow the directions in the email. You will be automatically redirected in 5 seconds';
        }
    		catch (Exception $e) {
    			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    		}
      $reg_stmt->close();
    }
    header("refresh:5;url=../index.php");
    include_once 'db_close_conn.php';
    exit();
  }
  else
  {
    header("Location: ../register.php");
    exit();
  }

 ?>
