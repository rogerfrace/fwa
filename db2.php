<?php
//new creds
if (gethostname()=="iMac.local") {
	$user = 'root';
	$password = 'root';
	$db = 'fwacomdb';
	$host = 'localhost';
	$port = 3306;
	
	$link = mysqli_init();
	$success = mysqli_real_connect(
	   $link,
	   $host,
	   $user,
	   $password,
	   $db,
	   $port
	);
} else {
	$user = 'fwacomdb';
	$password = 'Sn0wL3op4rd!';
	$db = 'fwacomdb';
	$host = 'fwacomdb.db.8381461.725.hostedresource.net';
	$port = 3306;
	
	$link = mysqli_init();
	$success = mysqli_real_connect(
	   $link,
	   $host,
	   $user,
	   $password,
	   $db,
	   $port
	);
	//old
	//$db = new mysqli('fwacomdb.db.8381461.725.hostedresource.net', 'fwacomdb' ,'Sn0wL3op4rd!', 'fwacomdb');
}

$query = "select * from prints where id=1";
$result = mysqli_query($link,$query) or die(mysqli_error());

?>