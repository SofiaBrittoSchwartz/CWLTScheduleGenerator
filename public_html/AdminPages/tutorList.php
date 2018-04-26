<style>
	
	html
	{
		background-color: #ffffff;
	}

	.column 
	{
	    float: left;
	    padding: 5px;
	}

	input
	{
		margin-top: 10px;
		border: solid thin;
		border-color: #80808052;
		font-size: 15px;
		font-family: Raleway;

	}

	h3
	{
		text-align: center;
		margin-top: 0px;
		margin-bottom: 13px;
	}

</style>

<html>
<body id = "tutorListBody" style = "margin: 3px;">

<?php
	$frameID = $_GET['frameID'];
	$file_contents = file_get_contents('../DataFiles/tutorList1.json');
	$json_a = json_decode($file_contents, true);
	
	echo '<script src="./adminForm.js"></script>';
	echo '<h6 style = "display: none" id = "holder" value = "'.$json_a.'"></h6>';
	
	// Student Name Column
	echo "<div class = 'row' style = 'width: 930px;'>";
	echo "<div class = 'column' id = 'name' style = 'width: 180px;'>";
	echo "<h3 style = 'margin-left: -5%;'> Name </h3>";
	
	// populate all the names of the tutors into the Name column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = '".$tutor['studentID']."-name' type = 'text' onfocusout = 'saveData(\"".$tutor['studentID']."\", \"name\")' value = '". $tutor['name'] ."'/>";
	}

	echo "</div>";

	// Job Title Column
	echo "<div class = 'column' id = 'position' style = 'width: 230px;'>";
	echo "<h3> Job Title(s) </h3>";

	// populate all the positions of the tutors into the Job Title column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = '".$tutor['studentID']."-position' type = 'text' onfocusout = 'saveData(\"".$tutor['studentID']."\", \"position\")' title = 'Please input a position title' value = '".implode(', ', $tutor['position'])."' style = 'width: 220px;'/>";
	}

	echo "</div>";

	// Email Column
	echo "<div class = 'column' id = 'studentID' style = 'width: 260px;'>";
	echo "<h3 style = 'margin-left: 0;'> Email </h3>";

	// populate all the email prefixes of the tutors (used as studentIDs because these must be unique) into the Email column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = '".$tutor['studentID']."-studentID' type = 'text' onfocusout = 'saveData(\"".$tutor['studentID']."\", \"studentID\")' title = 'Please input a studentID' value = '".$tutor['studentID']."' style = 'width: 125px;'/> @pugetsound.edu";
	}
	echo "</div>";

	// NumHours Column
	echo "<div class = 'column' id = 'numHours' style = 'width: 200px;'>";
	echo "<h3 style = 'margin-left: -45%; height: 18px;'> Number of Hours </h3>";
	echo "<p id = 'incorrectInput' style = \" visibility: hidden; color:red; margin-left: -15px; margin-top: -10px; height: 10px;\"> Input must be a number. </p>";

	foreach ($json_a as $tutor) 
	{
		echo "<input id = '".$tutor['studentID']."-numHours' type = 'text' onfocusout = 'saveData(\"".$tutor['studentID']."\",\"numHours\")' title = 'Please input the number of hours this tutor works' value = '".$tutor['numHours']."' style = ' width: 100px; text-align: center; margin-right: 20px; margin-top: 0px; margin-bottom: 10px;'/>";
	}

	echo "</div>";
	echo "</div>";
	echo "<button id = \"addBtn\" onclick = \"addTutor(".$frameID.")\" style = \"margin-top: 10px; margin-left: 10px; \">+</button>";
	echo "<p id=\"errorMessage\" style = 'display: inline; color: red; visibility: hidden;'> Please make sure all previous tutors have been assigned the necessary values <p>";
	// Use this value to set the height of the iFrame and/or body
	$height = 170 + (count($json_a) * 22);

	echo "<script> loadFile('../DataFiles/tutorList'); setFrameHeight('tutorListInput', ".$height."); </script>";
?>
</body>
</html>