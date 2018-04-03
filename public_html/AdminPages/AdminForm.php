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

<!-- <body onload = "loadFirst()"> -->
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

		<!-- Part 2: Special Events -->	
			<div class = "tab" id = "Something">
				<h2 style = "margin-bottom: -25px;">Something Else Events</h2>
				<iframe id = "SomethingInput" name = "1" frameborder= "0"> </iframe>
			</div>

		<!-- Part 3: List of Tutors -->
			<div class = "tab" id = "tutorList">
				
				<h2 style = "margin-right: 30px; margin-top: 40px; margin-bottom: -20px;"> List of Tutors </h2>
				
				<iframe src = "tutorList.php" frameborder="0" style = "width: 650px; height: 330px; margin-top: 5px;"></iframe>
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
			<div class = "tab">
				<h1 style = "margin-top: 80px; text-align: center;"> Thank you! </h1>
			</div>

		<!-- Buttons -->
			
			<div style="text-align: center; height: 10px;">
				<button type="button" id="prevBtn" onclick= "nextPrev('adminForm', -1)" style = "display: none;">Previous</button>
				<!-- <button type="button" id="prevBtn" onclick="nextPrev('adminForm', -1)" style = "display: none;">Previous</button> -->
				<button type="button" id="nextBtn" onclick= "nextPrev('adminForm', 1)">Next</button>
				<!-- <button type="button" id="nextBtn" onclick="switchFrame()">Next</button> -->
			</div>
			

	</form>

	
	<script src="../multipageForm.js"></script>
	<script type="text/javascript">
			
		showTab(0, true);
		// var scheduleStates2 = new Array();
		// var currentTab = 0;
		// // updateSchedule();

		// function save(inputType, day, time)
		// {
		// 	scheduleStates2[day][time] = inputType;
		// 	saveTimes(inputType, day, time);
		// }

		// // function storeSchedule(tabIndex, schedule)
		// function getNextPrev(variant)
		// {
		// 	console.log("storeSchedule");
		// 	// console.log("Schedule in adminForm: \n"+getSchedule().toString());
		// 	scheduleStates2[currentTab] = nextPrev('adminForm', variant, scheduleStates2[currentTab], currentTab);

		// 	currentTab += variant;

		// 	var tabs = document.getElementsByClassName("tab");

		// 	//sets iframe source if iframe isn't null
		// 	setIframe(tabs[curr].id + "Input");

		// 	// updateSchedule();
		// 	console.log("Updated Schedule: \n");
		// 	console.log(scheduleStates2);
		// }

		// function updateSchedule(sched, currTab)
		// {
		// 	scheduleStates2[currTab] = sched;
		// 	currentTab = currTab;
		// 	// var tempSched;
		// 	// tempSched, currentTab = getSchedule();
		// 	// console.log(currentTab);
		// 	// console.log(tempSched);
		// 	// scheduleStates2[currentTab] = tempSched;
		// }

	</script>

</body>

</html>