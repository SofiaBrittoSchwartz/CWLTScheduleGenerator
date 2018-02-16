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
		width: 580px;
		height: 520px;
		min-width: 300px;
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
		  <a href="#contact">Contact</a>
		  <a href="#about">About</a>
		</div>

<body>
	
	<!-- Marks how far through the form they are -->
		<div style="text-align:center; margin-right: 15px; margin-top:10%; float: left;">
		    <span class="step active"> <p style = "margin-top: 10px;"> Open Hours </p> </span> <br>
		    <span class="step"> <p style = "margin-top: 10px;"> Special Events </p> </span> <br>
		    <span class="step"> <p style = "margin-top: 10px;"> List of Tutors </p> </span> <br>
		    <span class="step"> <p style = "margin-top: 10px;"> Liaison Information </p> </span> <br>
		</div>

	<form id = "adminForm">

		<!-- Part 1: Open Hours Input -->	
			<div class = "tab">
				<h2 style = "margin-bottom: -25px;">Confirm Open Hours</h2>
				<!-- <p style = "margin-top: 10px;"> Please confirm that these are the open hours for this semester. </p> -->
				<iframe src= "../weeklySchedule.php" frameborder= "0"> </iframe>
			</div>

		<!-- Part 2: Special Events -->	
			<div class = "tab">
				<h2 style = "margin-bottom: -25px;"> Confirm Special Events </h2>
				<!-- <p> Please confirm that these are the times for the special events for this semester. </p> -->
				<iframe src= "../weeklySchedule.php" frameborder= "0"> </iframe>
			</div>

		<!-- Part 3: List of Tutors -->
			<div class = "tab">
				<h2 style = "margin-right: 30px; margin-top: 40px;"> Basic Info </h2>
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
			</div>

		<!-- Part 4: Liaison Information -->
			<div class = "tab">
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
			</div>

		<!-- Confirmation Screen -->
			<div class = "tab">
				<h1 style = "margin-top: 80px; text-align: center;"> Thank you! </h1>
			</div>

		<!-- Buttons -->
			
			<div style="text-align: center;">
				<button type="button" id="prevBtn" onclick="nextPrev('adminForm', -1)" style = "display: none;">Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev('adminForm', 1)">Next</button>
			</div>
			

	</form>
		
	<script src="../multipageForm.js"></script>

</body>

</html>