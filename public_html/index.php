<?php include('header.php'); ?>

<a href="#pasttalks">Skip to past talks</a><br>
<a href="#organisers">Contact the organisers</a>

<br />
<br />

The Imperial Junior Geometry seminar for 2021/22 is run from 5:30PM to 6:30PM every Friday. The seminar is in room 402 in the Imperial CDT space, and will be run hybrid online through Zoom or recorded for those who cannot attend in person.<br />

<br />
<b>Zoom link:</b> <a href="https://ucl.zoom.us/j/95828285409?pwd=eVZ0OUZqQXFEMEVIWWpyeUxoaHM4dz09&fbclid=IwAR3ye6FJMtHBuAM7HdZbE7YmhJQ-6-GOC62mZkWwMUisarjDEakT6Jo0fbU">Click here</a><br />
<b>Password:</b> geometry

<br>


<br>
<a href="https://mailman.ic.ac.uk/mailman/listinfo/junior-geometry">Sign up to mailing list</a>
<div class="clear"></div>
<h2>Upcoming Talks:</h2>

<?php

function printTalk($talk, $first=false)
{
	echo '<li class="talk';
	if ($first==true)
	{
		echo ' first';
	}
	echo '"><h3 class="title">Title: <span class="lighter">' . ($talk->title == '' ? 'TBA' : $talk->title) . '</span></h3>';
	echo '<h4 class="speakerdate">Speaker: <span class="lighter">' . $talk->speaker . ($talk->institution == ''? '' : ' - ' . $talk->institution) .'</span></h4>';
	echo '<h4 class="date">Date: <span class="lighter">' . date("l, d F Y", (strtotime($talk->date))) . '</span></h4>';
	echo '<h4 class="abstract">Abstract:</h4>
	<span class="lighter">' . ($talk->abstract == '' ? 'TBA' : nl2br($talk->abstract)) . '</span>';
	if ($talk->notes)
	{
		echo '<br><br>Notes accessible <a href="' . $talk->notes .'">here.</a>';
	}
	echo '</li>
	';
}

$currentdate = date("Ymd");

$talks = simplexml_load_file("talks.xml");

$pasttalks;
$futuretalks;

foreach ($talks as $talk)
{
	if ($talk->date < $currentdate)
	{
		$pasttalks[] = $talk;
	}
	else
	{
		$futuretalks[] = $talk;
	}
}

usort($futuretalks, "compareDates");
usort($pasttalks, "compareDates");

?>
<div class="insertAfterfuturetalks"></div>
<br>
<ul class="futuretalks" id="talklist">
	<?php foreach ($futuretalks as $key=>$talk) { printTalk($talk, $key == 0 ? true : false); } ?>
</ul>
<script> 
$('.futuretalks').paginathing({
	perPage: 5,
	firstLast: false,
	insertAfter: '.insertAfterfuturetalks'
});

</script>


<div class="clear"></div>
<h2 id="pasttalks">Past Talks:</h2>
<div class="insertAfterpasttalks"></div>
<br>
<ul class="pasttalks" id="talklist2">
	<?php foreach (array_reverse($pasttalks) as $talk) { printTalk($talk); } ?>
</ul>

<script> 
$('.pasttalks').paginathing({
	perPage: 5,
	firstLast: false,
	insertAfter: '.insertAfterpasttalks'
});
</script>


<div class="clear"></div>
<h2 id="organisers">Contact the Organisers:</h2>
<table>
	<tr>
		<td style="border:0;">Robert Crumplin</td>
		<td style="border:0;"><img src="email.php?email=<?php echo base64_encode('robert.crumplin.20@ucl.ac.uk'); ?>" style="display:inline; vertical-align: bottom;"></td>
	</tr>
	<tr>
		<td style="border:0;">Marta Benozzo</td>
		<td style="border:0;"><img src="email.php?email=<?php echo base64_encode('marta.benozzo.20@ucl.ac.uk'); ?>" style="display:inline; vertical-align: bottom;"></td>
	</tr>
</table>



<?php include('footer.php'); ?>