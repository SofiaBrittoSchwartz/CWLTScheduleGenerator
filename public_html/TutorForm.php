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
		height: 540px; 
		margin-left: -10px;
		margin-top: -15px;
	}

	p#incompleteTab
	{
		height: 5px;
	}

	h2
	{
		text-align: center;
	}

	.tooltip:hover .tooltiptext 
	{
	    visibility: visible;
	    opacity: 1;
	}

	.tooltip 
	{
	    position: relative;
	    display: inline-block;
	    border-bottom: 1px dotted black;
	}

	.tooltip .tooltiptext 
	{
	    visibility: hidden;
	    width: 470px;
	    background-color: #555;
	    color: #fff;
	    text-align: center;
	    border-radius: 6px;
	    padding: 5px 0;
	    position: absolute;
	    z-index: 1;
	    bottom: 125%;
	    left: 50%;
	    margin-left: -60px;
	    opacity: 0;
	    transition: opacity 0.3s;
	}

	.tooltip .tooltiptext::after 
	{
	    content: "";
	    position: absolute;
	    top: 100%;
	    left: 50%;
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #555 transparent transparent transparent;
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
				<div style = "margin-left: 30%;">
					<p id = 'incompleteTab' style = "visibility: hidden; color:red; margin-left: 100px;"> Please fill out all the necessary fields </p>
					<p style = "margin-left: 100px;">
						<label for = "name"> Name: </label>
						<input id = "studentName" type = "text" name = "studentName" title = "Please input your name" required/>
					</p>
					<p style = "margin-left: 100px;">
						<label for = "email"> School Email: </label>
						<input id = "email" type = "text" name = "email" title = "Please input your school email" required/> @pugetsound.edu
					</p>
					<p> 
						<div class="tooltip" style = "margin-left: 100px;"> Returning Tutor:
						  <span class="tooltiptext" style = "margin-left: -157px;">Check this box if this is NOT your first semester tutoring at the CWLT.</span>
						</div>
						<input id="vetStatus" type="checkbox" style = "display: inline; margin-left: 15px;"></p>
					</p>
				</div>
			</div>

		<!-- Part 2: Conflict Input -->	
			<div class = "tab" id = "ConflictTab">
				<h2 style = "margin-bottom: -45px; margin-left: -40px;"> Input Conflicts </h2>
				<p id = 'incompleteTab' style = "visibility: hidden; color:red;"> Please fill out all the necessary fields </p>
				<iframe id = "ConflictTabSchedule" name = "2" frameborder= "0" style = "height: 570px;"> </iframe>
			</div> 

		<!-- Part 3: Input Preferences -->	
			<div class = "tab" id = "preferences">
				<h2> Input Preferences </h2>
				<p id = 'incompleteTab' style = "visibility: hidden; color:red;"> Please fill out all the necessary fields </p>
				<iframe id = "preferencesSchedule" name = "1" frameborder= "0" style = "height: 570px;"> </iframe>
			</div>

		<!-- Confirmation Screen -->
			<div class = "tab" id = "confirmation">
				<iframe id = "confirmationScreen" name = "tutorForm" frameborder="0"> </iframe>
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

