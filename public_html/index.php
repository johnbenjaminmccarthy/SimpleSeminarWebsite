<?php include('header.php'); ?>

<a href="#pasttalks">Skip to past talks</a><br>
<a href="#organisers">Contact the organisers</a>

<br />
<br />

The seminar is run from A:00PM to B:00PM every Someday in room ABC of the DEF building.
<br />
<b>Zoom/Teams link:</b> <a href="https://zoom.us/">Click here</a><br />
<b>Password:</b> meetingpasswordhere

<br>


<br>
<a href="https://example.com/mailinglist">Sign up to mailing list</a>
<div class="clear"></div>


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
	<span class="lighter">' . ($talk->abstract == '' ? 'TBA' : nl2br(trim($talk->abstract))) . '</span>';
	if ($talk->notes)
	{
		echo '<br><br>Notes accessible <a href="' . $talk->notes .'">here.</a>';
	}
	echo '</li>
	';
}

$currentdate = date("Ymd");

$talks = simplexml_load_file("talks.xml");

$pasttalks = (array) null;
$futuretalks = (array) null;

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
<h2>Upcoming Talks:</h2>
<?php if ($futuretalks == null) {
    ?>There are no scheduled upcoming talks. Check back later.<?php
}
else { ?>
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
<?php } ?>

<div class="clear"></div>
<h2 id="pasttalks">Past Talks:</h2>
<?php if ($pasttalks == null) {
    ?>There are no past talks listed. Check back later. <?php
}
else {
    ?>
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
<?php } ?>

<div class="clear"></div>
<h2 id="organisers">Contact the Organisers:</h2>
<table>
	<tr>
		<td style="border:0;">Organiser 1</td>
		<td style="border:0;"><img src="email.php?email=<?php echo base64_encode('organiser1@university.edu.au'); ?>" style="display:inline; vertical-align: bottom;"></td>
	</tr>
	<tr>
		<td style="border:0;">Organiser 2</td>
		<td style="border:0;"><img src="email.php?email=<?php echo base64_encode('organiser2@university.edu.au'); ?>" style="display:inline; vertical-align: bottom;"></td>
	</tr>
</table>


<?php include('footer.php'); ?>