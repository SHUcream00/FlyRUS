<?php
  include_once 'check_login.php';
   #SQL setters
   $servername = "localhost";
   $username = "root";
   $password = "362proj";
   $dbname = "geekwaredb";

   $conn = new mysqli($servername, $username, $password, $dbname);

   if ($conn->connect_error)
   {
    die("Connection failed: " . $conn->connect_error);
   }

   #To add more cities, attach array(code, flight time, city name) BEFORE the last element(SNA)
   $cities = array(array("LAX", 1, "Los Angeles"), array("LHR", 12, "London"), array("JFK", 6, "New York"), array("NRT", 11, "Tokyo"), array("CDG", 13, "Paris"), array("DXB", 16, "Dubai"), array("DEL", 18, "New Delhi"), array("PEK", 13, "Beijing"), array("FCO", 15, "Rome"), array("SNA", 0, "Orange County"));
   $models = array(
		array(737, "ff_ff.ff_ff.ff_ff.ff_ff.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111.111_111"), 
		array(11, "ff_ff_ff.ff_ff_ff.ff_ff_ff.ff_ff_ff.ee_ff_ee.ff_ff_ff.ff_ff_ff.ff_ff_ff.ff_ff_ff.11_11e11_ee.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.ee_11111_ee.11_11111_ee.11_11111_ee.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11111_11.11_11e11_11.11_11e11_11.ee_11e11_11"),
		array(330, "ff_ff_ff.ff_ff_ff.ff_ff_ff.ff_ff_ff.ff_ff_ff.11_111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_1111_11.11_111_11.11_111_11.11_111_11.11_111_11")
	);
   $dcnt = 0;
   $entries = 500; #Modify this value to control number of generated random data
   srand(time());

   for ($i = 0; $i <= $entries; $i++)
   {
       $target = $cities[rand(0,count($cities) -2)];
       $model_target = $models[rand(0, count($models) -1)];
		$model = $model_target[0];
		$seat_struct = $model_target[1];
       $future = time() + (($dcnt % 14 + 1) * 24 * 60 * 60);
       $departure = rand(time() + (($dcnt % 14) * 24 * 60 * 60), $future);
       $arrival = $departure + ($target[1] * 60 * 60);
       $arrival_date = date("Y-m-d",$arrival);
       $arrival_time = date("H:i:s",$arrival);
       $departure_date = date("Y-m-d",$departure);
       $departure_time = date("H:i:s",$departure);
       $rand = rand(1,2);
       if (($rand % 2) == 0)
       {
			$flight_dest = $target[2];
           $flight_source = $cities[count($cities) -1][2];
           $dest_code = $target[0];
           $source_code = $cities[count($cities) -1][0];
		   }
       else
       {
           $flight_dest = $cities[count($cities) -1][2];
           $flight_source = $target[2];
           $dest_code = $cities[count($cities) -1][0];
           $source_code = $target[0];
       }
       $flight_code = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 3)), 0, 3)."-".substr(str_shuffle(str_repeat("0123456789", 3)), 0, 3);
       $flight_gate = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 1)), 0, 1).substr(str_shuffle(str_repeat("123456789", 1)), 0, 1);
       $flight_status  = "On Time"; #Fixed to "On Time" for now, easily fixable to make it random
       $dcnt++;

       echo $arrival_date." ".$departure_date." ".$arrival_time." ".$departure_time." ".$flight_dest." ".$flight_source." ".$dest_code." ".$source_code." ".$flight_gate." ".$flight_status." ".$model." ".$seat_struct."\n";

       #SQL
       #Check variable $flight_code for random generated flight label (i.e. UAL-078)
       #Currently dummy data is put in place of Model_ID and Seat_Struct
       $sql = "INSERT INTO AllFlights (Arrival_date, Departure_date, Arrival_time, Departure_time,
       Flight_destination, Flight_source, Destination_code, Source_code, Flight_gate, Flight_status, Model_ID, Seat_Struct) VALUES ('$arrival_date', '$departure_date', '$arrival_time', '$departure_time', '$flight_dest', '$flight_source', '$dest_code', '$source_code', '$flight_gate', '$flight_status', '$model', '$seat_struct')";

       if ($conn->query($sql) === TRUE)
       {
          echo "New record created successfully";
       }
       else
       {
          echo "Error: " . $sql . "<br>" . $conn->error;
       }
   }


   $conn->close();
   ?>
