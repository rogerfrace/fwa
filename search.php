<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
require('db2.php');
require('prefs.php');
require('functions.php');

$keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : '';
$sortorder = !empty($_GET['sortorder']) ? $_GET['sortorder'] : '';

#if ($keyword=="") { unset ($keyword); }
#if ($sortorder=="") { unset ($sortorder); }

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
$result = mysqli_query($link,$query) or die(mysqli_error());

if (mysqli_num_rows($result) == 1) {
	// if 1 result, redirect to specific page, otherwise start render
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		header("Location:detail.php?id=$id");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="See a list of artwork available from Frac&eacute; Wildlife Art">
	<meta name="keywords" content="wildlife art, nature art, Charles Frace, artist, painter, Somerset House Publishing, American Masters Foundation, Frame House Gallery, animals, lithographs, prints">
	<meta name="title" content="Frac&eacute; Wildlife Art - Artwork">
	<title>Frac&eacute; Wildlife Art - Artwork</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/reflection.js"></script>
	<script type="text/javascript" src="js/fwa.js"></script>
   	<link rel="stylesheet" type="text/css" href="fwa.css"> 
</head>
<body>
<?php include('googleanalytics.html'); ?>

<?php
require('sub_header.html');
?>

<main id="content">
<?php

if (mysqli_num_rows($result) == 0) {
	echo "<p align=center><font color=red>No results found.</font></p>";
} else {
	// display summary table
	echo "<table border=0 align=center cellpadding=10>";
	echo "<caption align=center>click column header to reorder your results</caption>";
	echo "<tr><th align='center' class='header'>IMAGE</td>
	<th align='left' class='header'><a href='search.php?keyword=$keyword&amp;sortorder=type'>TYPE</a></td>
	<th align='left' class='header'><a href='search.php?keyword=$keyword&amp;sortorder=title'>TITLE</a></td>
		</tr>";
	while ($row = mysqli_fetch_array($result)) {
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
		echo "<tr><td align='right'><a href='detail.php?id=$id'><img loading=\"lazy\" src='prints_tnail/$image' alt='' aria-labelledby='printtitle".$id." printtype".$id."' border='0'></a></td>
		<td><a href='detail.php?id=$id' id='printtype".$id."'>$type</a></td>
		<td><a href='detail.php?id=$id' id='printtitle".$id."'>$title</a></td>
		</tr>";
		
	} // end while loop
	echo "</table>";
	
} // end else multiple results

?>

</main> <!-- /content -->

</body>
</html>
