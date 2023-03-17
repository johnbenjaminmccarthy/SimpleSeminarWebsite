<?php
session_start(); //error_reporting(E_ALL); ini_set('display_errors', 1);
?>
<!DOCTYPE html 
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Imperial Junior Geometry Seminar<?php echo $page ? ' - ' . $page : '' ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
 <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./paginathing.js"></script>

<link rel="stylesheet" type="text/css" href="../vs.css" />
<script type="text/javascript" async
  src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/latest.js?config=TeX-MML-AM_CHTML">
</script>
</head>
<body>
<div id="contentColumn">
<div class="inside">

<div id="header">
<div id="logo">
<a href="http://wwwf.imperial.ac.uk/~jbm18/ijg">
Imperial <span class="orange">Junior</span> Geometry <span class="orange">Seminar</span>
</a>
</div>

<div class="clear"></div>
</div>

<ul id="navigation">
<li><a href="./index.php">Upcoming Talks</a></li>
<li><a href="https://www.homepages.ucl.ac.uk/~ucaheps/LSGNTtopics.html">Topics in Geometry</a></li>
<li><a href="http://geometry.ma.ic.ac.uk/seminar/">Imperial Geometry and Topology Seminar</a></li>
</ul>

<div class="clear"></div>
<div class="content">
<?php if (isset($page)) { ?>
<h2><?php echo $page; ?></h2>
<?php } 

function compareDates($talk1, $talk2)
{
	if (  (int)$talk1->date == (int)$talk2->date) {return 0; }
	return ((int)$talk1->date < (int)$talk2->date) ? -1 : 1;
}

function compareId($talk1, $talk2)
{
	if (  (int)$talk1[0]['id'] == (int)$talk2[0]['id']) {return 0; }
	return ((int)$talk1[0]['id'] < (int)$talk2[0]['id']) ? -1 : 1;
}



?>