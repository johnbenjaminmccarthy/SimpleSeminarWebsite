<?php $page='Add/Edit/Remove a Talk'; include('header.php'); ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	switch($_POST['formtype'])
	{
		case 'addtalk':
		$talksdoc = simplexml_load_file("talks.xml");
		$newindex = $talksdoc[0]['idcount'] + 1;
		$talksdoc[0]['idcount'] += 1;
		$newtalk = $talksdoc->addChild("talk");
		$newtalk->addAttribute("id", $newindex);
		$newtalk->addChild("title", htmlspecialchars($_POST["title"], ENT_XML1, 'UTF-8'));
		$newtalk->addChild("speaker", htmlspecialchars($_POST["speaker"], ENT_XML1, 'UTF-8'));
		$newtalk->addChild("institution", htmlspecialchars($_POST["institution"], ENT_XML1, 'UTF-8'));
		$newtalk->addChild("abstract", htmlspecialchars($_POST["abstract"], ENT_XML1, 'UTF-8'));
		$inputdate = strtotime($_POST['date']);
		$newdate = date('Ymd', $inputdate);
		$newtalk->addChild("date", $newdate);
		//echo htmlspecialchars($talksdoc->asXML());
		$talksdoc->asXML("talks.xml");
		echo "Talk added successfully!<br />";
		break;

		case 'deletetalk':
		$talksdoc = simplexml_load_file("talks.xml");
		unset($talksdoc->xpath('talk[@id="' . $_POST['deleteid'] . '"]')[0]->{0});
		$talksdoc->asXML("talks.xml");
		echo 'Talk successfully deleted!<br />';
		break;

		case 'edittalk':
		$talksdoc = simplexml_load_file("talks.xml");
		$talktoedit = $talksdoc->xpath('talk[@id="' . $_POST['editid'] . '"]')[0];
		?>
		<h3>Editing talk: <span class="lighter"><?php echo htmlspecialchars($talktoedit->title); ?></span></h3>
		<form action="addtalk.php" method="post" enctype="multipart/form-data" >
		<b>Title:</b> <input type="text" name="title" value="<?php echo htmlspecialchars($talktoedit->title);?>"><br />
		<b>Date:</b> <input type="date" name="date" value="<?php echo date("Y-m-d", strtotime($talktoedit->date));?>"><br />
		<b>Speaker:</b> <input type="text" name="speaker" value="<?php echo htmlspecialchars($talktoedit->speaker);?>"><br />
		<b>Institution:</b> <input type="text" name="institution" value="<?php echo htmlspecialchars($talktoedit->institution);?>"><br />
		<b>Abstract:</b><br />
		<textarea name="abstract"><?php echo htmlspecialchars($talktoedit->abstract);?></textarea><br />
		<input type="hidden" name="editid" value="<?php echo $_POST['editid'] ?>">
        <b>Upload notes:</b> <input type="file" name="notes" id="notes"><?php if ($talktoedit->notes) { echo " Current notes uploaded here: <a href='" . $talktoedit->notes . "'>" . basename($talktoedit->notes) ."</a>."; } ?><br />
		<button type="submit" name="formtype" value="submitedit" style="display:inline-block">Edit Talk</button> 
		</form><button onclick="window.location.href='addtalk.php'" style="display:inline-block; margin-top:10px;">Cancel Editing</button>
		<?php
		break;

		case 'submitedit':
		$talksdoc = simplexml_load_file("talks.xml");
		$talktoedit = $talksdoc->xpath('talk[@id="' . $_POST['editid'] . '"]')[0];
		$inputdate = strtotime($_POST['date']);
		$newdate = date('Ymd', $inputdate);
		$talktoedit->title = htmlspecialchars($_POST['title'], ENT_XML1, 'UTF-8');
		$talktoedit->speaker = htmlspecialchars($_POST['speaker'], ENT_XML1, 'UTF-8');
		$talktoedit->institution = htmlspecialchars($_POST['institution'], ENT_XML1, 'UTF-8');
		$talktoedit->date = $newdate;
		$talktoedit->abstract = trim(htmlspecialchars($_POST['abstract'], ENT_XML1, 'UTF-8'));

        if ($_FILES['notes']['name'] != '')
		{
            if (strtolower(pathinfo($_FILES['notes']['name'],PATHINFO_EXTENSION)) != 'pdf') {
                echo "Only PDF files are allowed as notes.";
            }
            else {
                $uploaddir = getcwd() . '/notes/';
                if (pathinfo($_FILES['notes']['name'], PATHINFO_FILENAME == pathinfo($talktoedit->notes,PATHINFO_FILENAME))) {
                    $_FILES['notes']['name'] = "(2)" . $_FILES['notes']['name'];
                }
                $uploadfile = $uploaddir . basename($_FILES['notes']['name']);
                $notesurl = './notes/' . basename($_FILES['notes']['name']);
                if (move_uploaded_file($_FILES['notes']['tmp_name'], $uploadfile))
                {
                    if ($talktoedit->notes != '')
                    {
                        try
                        {
                            //echo "Deleting " . $uploaddir . basename($talktoedit->notes);
                            unlink($uploaddir . basename($talktoedit->notes));
                        }
                        catch (Exception $e)
                        {
                            echo "Deleting old notes " . $talktoedit->notes . " failed. Exception:" . $e->getMessage();
                        }
                    }
                    $talktoedit->notes = $notesurl;
                    echo "File has been uploaded successfully <a href='" . $notesurl . "'>here</a><br />>";
                }
                else
                {
                    echo "File upload failed.";
                }
            }
		}
		$talksdoc->asXML("talks.xml");
		echo"Talk edited successfully!<br />";
		break;

		default:
		break;
	}
	
}

if ($_SERVER["REQUEST_METHOD"] != "POST" OR $_POST['formtype'] == 'addtalk' OR $_POST['formtype'] == 'deletetalk' OR $_POST['formtype'] == 'submitedit')
{
	?>
	<h3>Add a talk:</h3>
	<form action="addtalk.php" method="post">
	<b>Title:</b> <input type="text" name="title"><br />
	<b>Date:</b> <input type="date" name="date"><br />
	<b>Speaker:</b> <input type="text" name="speaker"><br />
	<b>Institution:</b> <input type="text" name="institution"><br />
	<b>Abstract:</b><br />
	<textarea name="abstract"></textarea><br />
	<button type="submit" name="formtype" value="addtalk" style="display:inline-block">Add Talk</button>
	</form>
	<?php
}

?>



<div class="clear"></div>
<h2>All talks:</h2>
<div class="clear"></div>
<?php

$talks = (array) simplexml_load_file("talks.xml");

usort($talks["talk"], "compareId");

?>

<table style="width:100%">
	<tr>
		<th style="width:5%">Id</th>
		<th style="width:20%">Title</th>
		<th style="width:10%">Speaker</th>
		<th style="width:5%">Institution</th>
		<th style="width:10%">Date</th>
		<th style="width:35%">Abstract</th>
        <th style="width:5%">Notes</th>
		<th style="width:10%"></th>
	</tr>
<?php

foreach ($talks["talk"] as $talk)
{
	echo '<tr>';
	echo '<td>' . $talk[0]['id'] . '</td>';
	echo '<td>' . htmlspecialchars($talk->title) . '</td>';
	echo '<td>' . htmlspecialchars($talk->speaker) . '</td>';
	echo '<td>' . htmlspecialchars($talk->institution). '</td>';
	echo '<td>' . date("Y-m-d", strtotime($talk->date)) . '</td>';
	echo '<td>' . nl2br(trim(htmlspecialchars($talk->abstract))) . '</td>';
    echo '<td>'; if ($talk->notes) { echo "<a href='" . $talk->notes . "'>" . $talk->notes . "</a>"; }; echo '</td>';
	echo '<td> <form action="addtalk.php" method="post"><input type="hidden" name="editid" value="' . $talk[0]['id'] . '"><button type="submit" name="formtype" value="edittalk">Edit</button></form><form action="addtalk.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete:\n ' . htmlspecialchars($talk->title) . '\n?\')"> <input type="hidden" name="deleteid" value="' . $talk[0]['id'] . '"><button type="submit" name="formtype" value="deletetalk">Delete</button></form></td>';
	echo '</tr>';

}

?>
</table>

<?php include('footer.php'); ?>