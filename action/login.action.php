<?php
session_start();
if(isset($_POST['login_header_submit']) || isset($_POST['login_page_submit']))
{

  include_once 'db_connect.php';

  $form_login_user = mysqli_real_escape_string($db_conn, $_POST['login_user']);
  $form_login_pass  = mysqli_real_escape_string($db_conn, $_POST['login_password']);

  if( empty($form_login_user) || empty($form_login_pass))
  {
    $_SESSION['login_error'] = "Empty Username or Password";
    header("Location: ../index.php?login=error");
    exit();
  }
  else
  {
    $login_user_query = "SELECT * FROM useracct WHERE Username='$form_login_user' ";
    $login_user_query_result = $db_conn->query($login_user_query);

    if(!$login_user_query_result->num_rows > 0)
    {

      $_SESSION['login_error'] = "Incorrect Username or Password";
      header("Location: ../index.php?login=error");
      exit();
    }
    else
    {
      if($user_row = $login_user_query_result->fetch_assoc())
      {
        $check_login_pass = password_verify($form_login_pass, $user_row['PASSWORD']);
        if($check_login_pass  == false)
        {
          $_SESSION['login_error'] = "Incorrect Username or Password";
          header("Location: ../index.php?login=error");
          exit();
        }
        elseif($check_login_pass == true)
        {
          $_SESSION['user_id'] = $user_row['User_ID'];
          $_SESSION['user_email'] = $user_row['Email'];
          $_SESSION['user_name'] = $user_row['Username'];
          $_SESSION['user_fname'] = $user_row['First_name'];
          $_SESSION['user_lname'] = $user_row['Last_name'];
        }
      }
    }
  }
  
  include_once 'db_close_conn.php';
  header("Location: ../index.php");
  exit();
}
else
{
  header("Location: ../index.php");
  exit();
}

?>
