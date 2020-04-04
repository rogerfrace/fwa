<?php
if (gethostname()=="iMac.local") {
	$user = 'root';
	$password = 'root';
	$db = 'fwacomdb';
	$host = '127.0.0.1';
	$port = 3306;
	$socket = 'localhost:/Applications/MAMP/tmp/mysql/mysql.sock';
	
	$link = mysqli_init();
	$success = mysqli_real_connect(
	   $link,
	   $host,
	   $user,
	   $password,
	   $db,
	   $port,
	   $socket
	);
} else {
$db_name = "fwacomdb";
$table_name = "prints";
$connection = mysql_connect("fwacomdb.db.8381461.725.hostedresource.net","fwacomdb","Sn0wL3op4rd!") or die("Could not connect to db");
$db = mysql_select_db($db_name, $connection) or die("Could not select database");
}
?>