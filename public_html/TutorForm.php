<!DOCTYPE html>
<style>

	/* FORMATTING FORM */

	* {
	  box-sizing: border-box;
	}

	body {
	  background-color: #f1f1f1;
	}

	input 
	{
	    display: table-cell;
  	} 

  	form  
  	{ 
	    display: table;  
	    margin-left: 10px;
  	}

  	label 
  	{
	    margin-left: 40px;
	    display: block; 
	    width: 185px;
	    float: left; 
	}

	p
	{
		margin-top: 30px;
	}

	#tutorForm {
		background-color: #ffffff;
		margin: 100px auto;
		font-family: Raleway;
		padding: 40px;
		width: 580px;
		height: 300px;
		min-width: 300px;
	}

	/* FORMATTING MULTIPAGE FORM */
		
		/* Hide all steps by default: */
		.tab {
		  display: none;
		}

		/* Make circles that indicate the steps of the form: */
		.step 
		{
		  height: 10px;
		  width: 10px;
		  margin: 0 2px;
		  background-color: #bbbbbb;
		  border: none;  
		  border-radius: 50%;
		  display: inline-block;
		  opacity: 0.5;
		}

		.step.active 
		{
		  background-color: #650000;
		  opacity: 1;
		}

		/* Mark the steps that are finished and valid: */
		.step.finish 
		{
		  background-color: #650000;
		  opacity: 0.5;
		}

	/* FORMATTING NAVBAR */

		/* Add a black background color to the top navigation */
		.topnav {
		    background-color: #333;
		    overflow: hidden;
		}

		/* Style the links inside the navigation bar */
		.topnav a {
		    float: left;
		    color: #f2f2f2;
		    text-align: center;
		    padding: 14px 16px;
		    text-decoration: none;
		    font-size: 17px;
		    width: 100px;
		}

		/* Change the color of links on hover */
		.topnav a:hover {
		    background-color: #ddd;
		    color: black;
		}

		/* Add a color to the active/current link */
		.topnav a.active {
		    background-color: #650000;
		    color: white;
		}

</style>

<html>
	<body>
		<div class="topnav">
		  <a class="active" href="#home">Home</a>
		  <a href="#news">News</a>
		  <a href="#contact">Contact</a>
		  <a href="#about">About</a>
		</div>
		
		<!-- Marks how far through the form they are -->
		<div style="text-align:center; margin-right: 30px; margin-top:30px;">
		    <span class="step"></span>
		    <span class="step"></span>
		    <span class="step"></span>
		</div>

		<!-- <div id="tutorForm" style = "margin-top:30px; border-style: solid;"> -->
		<form id = "tutorForm">
		<!-- Part 1: Basic info -->
			<div class = "tab">
				<h2 style = "text-align: center; margin-right: 30px; margin-top: 20px;"> Basic Info </h2>
				<!-- <form style = "border: black;" onsubmit = "nextPrev(1)"> -->
				<div>
					<p>
						<label for = "name"> Name: </label>
						<input id = "studentName" type = "text" name = "studentName" title = "Please input your name" required/>
					</p>
					<p>
						<label for = "email"> School Email: </label>
						<input id = "email" type = "text" name = "email" title = "Please input your school email" required/> @pugetsound.edu
					</p>
				</div>
				<!-- </form> -->
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

			<div style="overflow:auto;">
				<div style="text-align: center;">
					<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
					<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
				</div>
			</div>

		<!-- </div> -->
		</form>

		<script>
			var currentTab = 0; // Current tab is set to be the first tab (0)
			showTab(currentTab); // Display the current tab

			function adjustFrame(variant)
			{
				var frame = document.getElementById("tutorForm");
				var tabs = document.getElementsByClassName("tab");

				if(variant == 1)
				{
					frame.style.width = "880px";
					frame.style.height = "720px";	
				}
				else if(variant == -1 && (currentTab == 0 || currentTab == tabs.length - 1))
				{
					frame.style.width = "580px";
					frame.style.height = "300px";	
				}
				
			}

			function showTab(variant) 
			{
			  // This function will display the specified tab of the form...
			  var tabs = document.getElementsByClassName("tab");
			  tabs[variant].style.display = "block";
			  
			  //... and fix the Previous/Next buttons:
			  if (variant == 0) {
			    document.getElementById("prevBtn").style.display = "none";
			  } 
			  else {
			    document.getElementById("prevBtn").style.display = "inline";
			    document.getElementById("nextBtn").style = "margin-left: 15px";
			    document.getElementById("prevBtn").style  = "margin-right: 15px";
			  }

			  // second to last button click will title name of nextBtn from Next to Submit
			  if (variant == (tabs.length - 2)) 
			  {
			    document.getElementById("nextBtn").innerHTML = "Submit";
			  } 
			  else if (variant == (tabs.length - 1))
			  {
			  	document.getElementById("prevBtn").style.display = "none";
			    document.getElementById("nextBtn").style.display = "none";
			  }
			  else
			  {
			    document.getElementById("nextBtn").innerHTML = "Next";
			  }
			  //... and run a function that will display the correct step indicator:
			  fixStepIndicator(variant)
			}

			function nextPrev(variant) 
			{
			  // This function will figure out which tab to display
			  var tabs = document.getElementsByClassName("tab");
			  
			  // Exit the function if any field in the current tab is invalid:
			  if (variant == 1 && !validateForm()) return false;
			  
			  // Hide the current tab:
			  tabs[currentTab].style.display = "none";
			  
			  // Increase or decrease the current tab by 1:
			  currentTab = currentTab + variant;
			  
			  // if you have reached the end of the form...
			  if (currentTab >= tabs.length-1) {

			    adjustFrame(-1);
			  	showTab(currentTab);

			    // ... the form gets submitted:
			    document.getElementById("tutorForm").submit();

			    return false;
			  }

			  // Otherwise, display the correct tab:
			  adjustFrame(variant);
			  showTab(currentTab);
			  window.scrollTo(125, 125);
			}

			function validateForm() 
			{
			  // This function deals with validation of the form fields
			  var x, y, i, valid = true;
			  x = document.getElementsByClassName("tab");
			  y = x[currentTab].getElementsByTagName("input");
			  // A loop that checks every input field in the current tab:
			  for (i = 0; i < y.length; i++) {
			    // If a field is empty...
			    if (y[i].value == "") {
			      // add an "invalid" class to the field:
			      y[i].className += " invalid";
			      // and set the current valid status to false
			      valid = false;
			    }
			  }
			  // If the valid status is true, mark the step as finished and valid:
			  if (valid) {
			    document.getElementsByClassName("step")[currentTab].className += " finish";
			  }
			  return valid; // return the valid status
			}

			function fixStepIndicator(n) 
			{
			  // This function removes the "active" class of all steps...
			  var i, x = document.getElementsByClassName("step");
			  for (i = 0; i < x.length; i++) {
			    x[i].className = x[i].className.replace(" active", "");
			  }
			  //... and adds the "active" class on the current step:
			  if(n < x.length)
			  {
			  	x[n].className += " active";	
			  }
			}

			function submit()
			{
				console.log("hello");
			}
		</script>
	</body>
</html>

