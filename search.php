<?
require('db.php');
require('prefs.php');
require('functions.php');

$keyword = $_POST['keyword'];
$sortorder = $_POST['sortorder'];

if ($keyword=="") { unset ($keyword); }
if ($sortorder=="") { unset ($sortorder); }

// check for presence of keyword or sortorder
if (substr($keyword,0,1) == "=") {
	$keyword = substr($keyword,1,strlen($keyword)-1);
	$query = "SELECT DISTINCT id, type, image, title FROM prints WHERE title=\"".$keyword."\"";
} elseif (($keyword) && ($sortorder)) {
	$query = "SELECT DISTINCT id, type, image, title FROM prints WHERE title LIKE '%".$keyword."%' OR subject LIKE '%".$keyword."%' ORDER BY ".$sortorder;
} elseif (($keyword) && (!$sortorder)) {
	$query = "SELECT DISTINCT id, type, image, title FROM prints WHERE title LIKE '%".$keyword."%' OR subject LIKE '%".$keyword."%' ORDER BY title";
} elseif ((!$keyword) && ($sortorder)) {
	$query = "SELECT DISTINCT id, type, image, title FROM prints ORDER BY ".$sortorder;
} else {
	$query = "SELECT DISTINCT id, type, image, title FROM prints ORDER BY title";
}

// execute sql
$result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($result) == 1) {
	// if 1 result, redirect to specific page, otherwise start render
	while ($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		header("Location:detail.php?id=$id");
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="en-us">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="See a list of artwork available from Frac&eacute; Wildlife Art">
	<meta name="keywords" content="wildlife art, nature art, Charles Frace, artist, painter, Somerset House Publishing, American Masters Foundation, Frame House Gallery, animals, lithographs, prints">
	<meta name="title" content="Frac&eacute; Wildlife Art - Artwork">
	<title>Frac&eacute; Wildlife Art - Artwork</title>
	<script type="text/javascript" src="js/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" src="js/reflection.js"></script>
	<script type="text/javascript" src="js/fwa.js"></script>
   	<link rel="stylesheet" type="text/css" href="fwa.css"> 
</head>
<body>

<?
require('sub_header.html');
?>

<div id="content">

<?

if (mysql_num_rows($result) == 0) {
	echo "<p align=center><font color=red>No results found.</font></p>";
} else {
	// display summary table
	echo "<table border=0 align=center cellpadding=10>";
	echo "<tr><td colspan=4 align=center>click column header to reorder your results</td></tr>";
	echo "<tr><td align='center' class='header'>IMAGE</td>
	<td align='left' class='header'><a href='search.php?keyword=$keyword&amp;sortorder=type'>TYPE</a></td>
	<td align='left' class='header'><a href='search.php?keyword=$keyword&amp;sortorder=title'>TITLE</a></td>
		</tr>";
	while ($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$type = $row['type'];
		$image = $row['image'];
		$title = $row['title'];
		
		// check for existance of big image
		if (!file_exists("$root_path/prints/$image")) {
			$image = "no_image.jpg";
		}
		// check for image tnail
		if (!file_exists("$root_path/prints_tnail/$image")) {
			make_thumbnail("$root_path/prints/$image","$root_path/prints_tnail/$image");
			flush();
		}
		// create and display row
		echo "<tr><td align='right'><a href='detail.php?id=$id'><img src='prints_tnail/$image' border='0'></a></td>
		<td><a href='detail.php?id=$id'>$type</a></td>
		<td><a href='detail.php?id=$id'>$title</a></td>
		</tr>";
		
	} // end while loop
	echo "</table>";
	
} // end else multiple results

?>

</div> <!-- /content -->

<? include('googleanalytics.html'); ?>
</body>
</html>