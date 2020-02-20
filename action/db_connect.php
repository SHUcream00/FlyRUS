<?php

$db_server_name = "localhost";
$db_user_name   = "root";
$db_pass        = "362proj";
$db_name        = "geekwaredb";


$db_conn = new mysqli($db_server_name, $db_user_name, $db_pass, $db_name);

if($db_conn->connect_error)
{
  die("Failed to connect to database: " . $db_conn->connect_error);
}


?>
