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
		width: 990px;
		height: 520px;
		min-width: 300px;
	}

	#tab
	{
		height: 500px;
	}

	iframe
	{
		-webkit-transform: scale(0.90); 
		-moz-transform-scale(0.75); 
		width: 815px; 
		/*width: 90%;*/
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
			    <span class="step"> <p style = "margin-top: 10px;"> Special Events </p> </span> <br></br>
			    <span class="step"> <p style = "margin-top: 10px;"> List of Tutors </p> </span> <br></br>
			    <!-- <span class="step"> <p style = "margin-top: 10px;"> Liaison Information </p> </span> <br> -->
			</div>

		<!-- Part 1: Open Hours Input -->	
			<div class = "tab" id = "OpenHours">
				<h2 id = "scheduleTitle" style = "margin-bottom: -25px;">Confirm Open Hours</h2>
				<iframe id = "OpenHoursInput" name = "-1" frameborder= "0"></iframe>
				
			</div>

		<!-- Part 2: Special Events -->	
			<div class = "tab" id = "SpecialEvents">
				<h2 style = "margin-bottom: -25px;">Confirm Special Events</h2>
				<iframe id = "SpecialEventsInput" name = "2" frameborder= "0"> </iframe>
			</div>

		<!-- Part 3: List of Tutors -->
			<div class = "tab" id = "tutorList">
				
				<h2 style = "margin-right: 30px; margin-top: 40px; margin-bottom: -20px;"> List of Tutors </h2>
				<iframe src = "tutorList.php" id = "tutors" frameborder="0" style = "width: 650px; height: 330px; margin-top: 5px;"></iframe>
				<input type = "file" style = "margin-left: 45%; margin-bottom: 15px;"></input>
				<!-- <h3> Use a JS function to resize the tab div && the iframe based on the size of the number of items in tutorList.json </h3> -->

			</div>

		<!-- Part 4: Liaison Information -->
			<!-- <div class = "tab">
				<h2 style = "text-align: center; margin-right: 30px; margin-top: 20px;"> Liaison Information </h2>
				<div>
					<p style = "margin-left: 100px;">
						<label for = "name"> Name: </label>
						<input id = "studentName" type = "text" name = "studentName" title = "Please input your name" required/>
					</p>
					<p style = "margin-left: 100px;">
						<label for = "email"> School Email: </label>
						<input id = "email" type = "text" name = "email" title = "Please input your school email" required/> @pugetsound.edu
					</p>
				</div>
			</div> -->

		<!-- Confirmation Screen -->
			<div class = "tab" id = "confirmation">
				<iframe id = "confirmationScreen" frameborder="0"> </iframe>
			</div>

		<!-- Buttons -->
			
			<div style="text-align: center; height: 10px;" id = 'btnHolder'>
				<button type="button" id="prevBtn" onclick= "nextPrev('adminForm', -1)" style = "display: none;">Previous</button>
				<button type="button" id="nextBtn" onclick= "nextPrev('adminForm', 1)">Next</button>
				
				<!-- <input type="submit" id="submit" visibility = "hidden"></input> -->
			</div>
			

	</form>

	
	<script src="../multipageForm.js"></script>
	<script>
			
		showTab(0, true);

	</script>

</body>

</html>