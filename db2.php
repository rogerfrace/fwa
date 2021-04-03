<?php

//echo "here";
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "fwacomdb";
	

$conn= mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected Successfully.";


//$query = "select * from prints where id=1";
//$result = mysqli_query($conn,$query) or die(mysqli_error());

?>