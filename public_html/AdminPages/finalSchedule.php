<!DOCTYPE html>
<style>
	
	iframe
	{
		width: 1000px;
		height: 500px;
	}

</style>

<link rel="stylesheet" href="../CSS/navbar.css">

<html>

	<!-- Navbar -->
	<div class="topnav">
	  <a href="#home">Home</a>
	  <a class="active" href="../AdminPages/adminForm.php">Admin</a>
	  <a href="/AdminPages/tutorFormCompletion.php" style = "width: 200px;"> Tutor Form Completion </a>
	  <a href="/AdminPages/finalSchedule.php" style = "width: 200px;"> Final Schedule </a>
	</div>

	<body>

		<iframe id = "finalScheduleiFrame" src = "finalScheduleGenerator.php" frameborder="0"></iframe>

	</body>

</html>