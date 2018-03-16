<style>

	.column 
	{
	    float: left;
	    width: 50%;
	    padding: 10px;
	    height: 300px; /* Should be removed. Only for demonstration */
	}

	input
	{
		margin-top: 10px;
		border: solid thin grey;
	}

	h3
	{
		text-align: center;
		margin-top: 0px;
		margin-bottom: 13px;
	}

</style>

<html>
<body style = "margin: 3px;">
<?php
	$string = file_get_contents("tutorList.json");
	$json_a = json_decode($string, true);

	// Student Name Column
	echo "<div class = 'row' style = 'width: 800px;'>";
	echo "<div class = 'column' style = 'width: 180px;'>";
	echo "<h3 style = 'margin-left: 10px;'> Name </h3>";
	
	// populate all the names of the tutors into the Name column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = 'tutorName' type = 'text' name = 'tutorName' title = 'Please input a name' placeholder = '". $tutor['name'] ."' style = 'margin-left: 20%;'/>";   
	}

	echo "</div>";

	// Job Title Column
	echo "<div class = 'column' style = 'width: 170px;'>";
	echo "<h3 style = 'margin-left: -10px;'> Job Title </h3>";

	// populate all the positions of the tutors into the Job Title column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = 'position' type = 'text' name = 'position' title = 'Please input a position title' placeholder = '".$tutor['position']."' style = 'margin-left: 10%;'/>";
	}

	echo "</div>";

	// Email Column
	echo "<div class = 'column' style = 'width: 300px;'>";
	echo "<h3 style = 'margin-left: -80px;'> Email </h3>";

	// populate all the email prefixes of the tutors (used as studentIDs because these must be unique) into the Email column
	foreach ($json_a as $tutor) 
	{
		echo "<input id = 'studentID' type = 'text' name = 'studentID' title = 'Please input a studentID' placeholder = '".$tutor['studentID']."' style = 'margin-left: 5%; width: 100px;'/>@pugetsound.edu";
	}

	echo "</div>";
	echo "</div>";

?>
</body>
</html>