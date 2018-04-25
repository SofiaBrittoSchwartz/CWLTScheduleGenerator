<!DOCTYPE html>

<link rel="stylesheet" href="../CSS/navbar.css">
<link rel="stylesheet" href="../CSS/multipageForm.css">
<link rel="stylesheet" href="../CSS/form.css">

<style>

	#adminForm 
	{
		float: center;
		background-color: #ffffff;
		font-family: Raleway;
		width: 1200px;
		height: 300px;
		min-width: 300px;
	}

	#tab
	{
		height: 300px;
	}

	p#incompleteTab
	{
		height: 5px;
	}

	iframe
	{
		-webkit-transform: scale(0.90); 
		-moz-transform-scale(0.75); 
		width: 815px; 
		height: 570px; 
		margin-left: -10px;
		margin-top: 11px;
	}

	h2
	{
		text-align: center;
	}

</style>

<html>

	<!-- Navbar -->
		<div class="topnav">
		  <a href="#home">Home</a>
		  <a class="active" href="../AdminPages/adminForm.php">Admin</a>
		  <a href="/AdminPages/tutorFormCompletion.php" style = "width: 200px;"> Tutor Form Completion </a>
		</div>

<body>
	
	<form id = "adminForm">

		<!-- Marks how far through the form they are -->
			<div style="text-align:center; margin-right: 15px; margin-top:10%; float: left;">
			    <span class="step active"> <p style = "margin-top: 10px;"> Open Hours </p> </span> <br></br>
			    <!-- <span class="step"> <p style = "margin-top: 10px;"> Special Events </p> </span> <br></br> -->
			    <span class="step"> <p style = "margin-top: 10px;"> List of Tutors </p> </span> <br></br>
			</div>

		<!-- Part 1: Open Hours Input -->	
			<!-- <div class = "tab" id = "OpenHours" style = "width: 1000px;">
				<br><h2 id = "scheduleTitle" style = "margin-bottom: -25px; margin-left: -40px;">Confirm Open Hours</h2>
				<p id = 'incompleteTab' style = "visibility: hidden; color:red;"> Please fill out all the necessary fields </p>
				<iframe id = "OpenHoursSchedule" name = "-1" frameborder= "0"></iframe>
			</div> -->

		<!-- Part 2: Special Events -->	
			<!-- <div class = "tab" id = "SpecialEvents">
				<h2 style = "margin-bottom: -25px;">Confirm Special Events</h2>
				<iframe id = "SpecialEventsInput" name = "2" frameborder= "0"> </iframe>
			</div> -->

		<!-- Part 3: List of Tutors -->
			<div class = "tab" id = "tutorList">
				
				<h2 style = "margin-right: 30px; margin-top: 40px;"> List of Tutors </h2>
				<p id = 'incompleteTab' style = "visibility: hidden; color:red;"> Please fill out all the necessary fields </p>
				<iframe id = "tutorListInput" src = "tutorList.php?frameID='tutorListInput'" frameborder="0" style = "width: 930px; height: 320px; margin-top: 5px;"></iframe>
				<input type = "file" style = "margin-left: 45%; margin-bottom: 15px;"></input>

			</div>

		<!-- Confirmation Screen -->
			<div class = "tab" id = "confirmation">
				<iframe id = "confirmationScreen" name = "adminForm" frameborder="0"> </iframe>
			</div>

		<!-- Buttons -->
			
			<div style="text-align: center; height: 10px;" id = 'btnHolder'>
				<button type="button" id="prevBtn" onclick= "nextPrev('adminForm', -1)" style = "display: none;">Previous</button>
				<button type="button" id="nextBtn" onclick= "nextPrev('adminForm', 1)">Next</button>
			</div>

	</form>

	
	<script src="../multipageForm.js"></script>
	<script>
			
		showTab(0, true);

	</script>

</body>

</html>