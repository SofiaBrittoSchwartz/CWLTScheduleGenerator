<!DOCTYPE html>
	
<link rel="stylesheet" href="CSS/navbar.css">
<link rel="stylesheet" href="CSS/multipageForm.css">
<link rel="stylesheet" href="CSS/form.css">

<style>
	
	p
	{
		margin-top: 30px;
	}

	#tutorForm 
	{
		background-color: #ffffff;
		margin: 100px auto;
		margin-top: 30px;
		font-family: Raleway;
		padding: 40px;
		width: 580px;
		height: 300px;
		min-width: 300px;
	}

</style>

<html>
	<body>
		<div class="topnav">
		  <a class="active" href="#home">Home</a>
		  <a href="/adminForm.php">Admin</a>
		  <a href="#contact">Contact</a>
		  <a href="#about">About</a>
		</div>
		
		<!-- Marks how far through the form they are -->
		<div style="text-align:center; margin-right: 30px; margin-top:30px; float: left;">
		    <span class="step active"> Basic Info </span> <br>
		    <span class="step"> Conflicts </span> <br>
		    <span class="step"> Work Preferences </span> <br>
		    <!-- <span class="step" style = "border-bottom: solid thin;"> Work Preferences </span> <br> -->
		</div>

		<form id = "tutorForm" style = "border-style: solid;">
		
		<!-- Part 1: Basic info -->
			<div class = "tab">
				<h2 style = "text-align: center; margin-right: 30px; margin-top: 20px;"> Basic Info </h2>
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

		<!-- Part 2: Conflict Input -->	
			<div class = "tab">
				<h2 style = "text-align: center; margin-top: -20px;"> Input Conflicts </h2>
				<iframe src= "weeklySchedule.php" style =  "height: 570px; width: 815px; margin-left: -10px;" frameborder= "0"> </iframe>
			</div>

		<!-- Part 3: Input Preferences -->	
			<div class = "tab">
				<h2 style = "text-align: center; margin-top: -20px;"> Input Preferences </h2>
				<iframe src= "weeklySchedule.php" style =  "height: 570px; width: 815px; margin-left: -10px;" frameborder= "0"> </iframe>
			</div>

		<!-- Confirmation Screen -->
			<div class = "tab">
				<h1 style = "margin-top: 80px; text-align: center;"> Thank you! </h1>
			</div>

		<!-- Buttons -->
			<div style="overflow:auto;">
				<div style="text-align: center;">
					<button type="button" id="prevBtn" onclick="nextPrev('tutorForm', -1)" style = "display: none;">Previous</button>
					<button type="button" id="nextBtn" onclick="nextPrev('tutorForm', 1)">Next</button>
				</div>
			</div>

		</form>

		<script src="multipageForm.js"></script>
		
	</body>
</html>

