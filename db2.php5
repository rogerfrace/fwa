<?php
//new creds
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
$db = new mysqli('fwacomdb.db.8381461.725.hostedresource.net', 'fwacomdb' ,'Sn0wL3op4rd!', 'fwacomdb');
}
?>