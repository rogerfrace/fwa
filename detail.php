<?
$id = $_GET['id'];
if ( (!$id) || (!is_numeric($id)) ) {
	header("Location: search.php");
}
require('db.php');
require('prefs.php');
require('functions.php');

$query = "SELECT id, type, image, title, subject, year, size FROM prints WHERE id=$id LIMIT 1";
$result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($result) < 1) {
	header("Location: search.php");
}

while ($row = mysql_fetch_array($result)) {
	$id = $row['id'];
	$type = $row['type'];
	$image = $row['image'];
	$title = $row['title'];
	$subject = $row['subject'];
	$year = $row['year'];
	$size = $row['size'];
}

# date translation
if (($year) && ($year != NULL) && ($year != "0000-00-00")) {
	if (strstr($year,'-00-00')) {
		$year = str_replace('-00-00','',$year);
	} else {
		$year = date('F Y',strtotime($year));
	}
} else {
	$year="";
}

# clean up subject
$newsubject = explode("/",$subject);
$subject = $newsubject[0];

# setup up keywords
if ($title == $subject) {
	$headmeta = $title;
} else {
	$headmeta = $title.", ".$subject;
}

?>

<!DOCTYPE html>
<html	lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="<? echo $headmeta; ?>, wildlife art, nature art, Charles Frace, artist, painter, Somerset House Publishing, American Masters Foundation, Frame House Gallery, animals, lithographs, prints">
	<meta name="title" content="Frac&eacute; Wildlife Art - <? echo $title; ?>">
	<script type="text/javascript" src="js/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" src="js/fwa.js"></script>
	<link rel="stylesheet" type="text/css" href="fwa.css"> 
	<title>Frac&eacute; Wildlife Art - <? echo $title; ?></title>
</head>
<body id="detail">

<?php
require('sub_header.html');
?>

<p>&nbsp;</p>

<?php
// check for existance of big image
if (!file_exists("$root_path/prints/$image")) {
	$image = "no_image.jpg";
}
?>

<div id="content" itemscope itemtype="http://schema.org/Painting">
	<img src="prints/<?=$image;?>" id="printImg" alt="<?=$title;?>" itemprop="image">
	<div class="prinfo">
		<h1 itemprop="name"><?=$title;?></h1>
		<p><i>subject:</i> <span itemprop="about"><?=$subject;?></span>
		<br><i>availability:</i> <?=$type;?>
		<br><i>date:</i> <span itemprop="dateCreated"><?=$year;?></span>
		<br><i>image size:</i> <?=$size;?></p>
		<meta itemprop="genre" content="Wildlife" />
		<div itemprop="creator" itemscope itemtype="http://schema.org/Person">
			<meta itemprop="name" content="Charles Frac&eacute;" />
			<meta itemprop="birthDate" content="February 10, 1926" />
			<meta itemprop="deathDate" content="December 16, 2005" />
		</div>
	</div>
</div> <!-- /content -->

<? include('googleanalytics.html'); ?>
</body>
</html>