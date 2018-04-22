<!DOCTYPE html>
	
<link rel="stylesheet" href="CSS/navbar.css">
<link rel="stylesheet" href="CSS/multipageForm.css">
<link rel="stylesheet" href="CSS/form.css">

<style>

	#tutorForm 
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

	iframe
	{
		-webkit-transform: scale(0.90); 
		-moz-transform-scale(0.75); 
		width: 815px; 
		/*width: 90%;*/
		height: 540px; 
		margin-left: -10px;
		margin-top: 11px;
	}

	h2
	{
		text-align: center;
	}

</style>

<html>
	<body>
		<div class="topnav">
		  <a class = "active" style = "width: 350px;"> Center for Writing, Learning & Teaching </a>
		</div>

		<form id = "tutorForm">
			
			<!-- Marks how far through the form they are -->
			<div style="text-align:center; margin-right: 15px; margin-top:10%; float: left;">
			    <span class="step active"> <p style = "margin-top: 10px;"> Basic Info </p> </span> <br></br>
			    <span class="step"> <p style = "margin-top: 10px;"> Conflicts </p></span> <br></br>
			    <span class="step"> <p style = "margin-top: 10px;"> Work Preferences </p> </span> <br>
			</div>

		<!-- Part 1: Basic info -->
			<div class = "tab" id = "basicInfoTab">
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
			<div class = "tab" id = "ConflictTab">
				<br>
				<h2 style = "margin-bottom: -25px; margin-left: -40px;"> Input Conflicts </h2>
				<iframe id = "ConflictTabInput" name = "2" frameborder= "0"> </iframe>
			</div> 
			<!-- "height: 570px; width: 815px; margin-left: -10px;" -->

		<!-- Part 3: Input Preferences -->	
			<div class = "tab" id = "preferences">
				<h2> Input Preferences </h2>
				<iframe id = "preferencesInput" name = "1" frameborder= "0"> </iframe>
			</div>

		<!-- Confirmation Screen -->
			<div class = "tab" id = "confirmation">
				<iframe id = "confirmationScreen" frameborder="0"> </iframe>
			</div>

		<!-- Buttons -->

			<div style="text-align: center; height: 10px;" id = 'btnHolder'>
				<button type="button" id="prevBtn" onclick="nextPrev('tutorForm', -1)" style = "display: none;">Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev('tutorForm', 1)">Next</button>
			</div>

		</form>

		<script src="multipageForm.js"></script>
		<script>
			
		showTab(0, true);

		</script>
	</body>
</html>

