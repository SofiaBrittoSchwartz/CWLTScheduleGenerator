<link rel="stylesheet" href="../CSS/navbar.css">

<style>
	.column 
	{
	    float: left;
	    width: 50%;
	    padding: 10px;
	    height: 300px; /* Should be removed. Only for demonstration */
	}
</style>

<html>
	<!-- Navbar -->
		<div class="topnav">
		  <a href="#home">Home</a>
		  <a href="../AdminPages/adminForm.php">Admin</a>
		  <a class="active" href="/AdminPages/tutorFormCompletion.php" style = "width: 200px;"> Tutor Form Completion </a>
		  <a href="#about">About</a>
		</div>

	<body>

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
				echo "<p style ='margin: 0px;'>". $tutor['name'] ."<p/>";   
			}

			echo "</div>";

			// Form Completion Column
			echo "<div class = 'column' style = 'width: 300px;'>";
			echo "<h3 style = 'margin-bottom: 22px;'> Form Completed </h3>";

			// populate all the email prefixes of the tutors (used as studentIDs because these must be unique) into the Email column
			foreach ($json_a as $tutor)
			{
				echo "<input id = 'completionStatus' type = 'checkbox' placeholder = 'true' style = 'margin: 0px; display: block;' checked disabled/> <br>";
			}

			echo "</div>";
			echo "</div>";

		?>
	</body>
</html>