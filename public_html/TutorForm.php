<!DOCTYPE html>
<style>

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
	  opacity: 1;
	}

	/* Mark the steps that are finished and valid: */
	.step.finish 
	{
	  background-color: #4CAF50;
	}

</style>
<html>
	<body>
		<div id="tutorForm" style = "width: 480px">
			<div style="text-align:center;margin-top:40px; margin-right: 30px;">
			    <span class="step"></span>
			    <span class="step"></span>
			    <span class="step"></span>
				<span class="step"></span>
			</div>
			
			<div class = "tab">
				<h2 style = "text-align: center; margin-right: 30px;"> Basic Info </h2>
				<form style = "border: black;">
					<p>
						<label for = "name"> Name: </label>
						<input id = "studentName" type = "text" name = "studentName" title = "Please input your name" required/>
					</p>
					<p>
						<label for = "email"> School Email: </label>
						<input id = "email" type = "text" name = "email" title = "Please input your school email" required/> @pugetsound.edu
					</p>
					<p>
						<label for = "returnerStatus" style = "width: 185px"> Tutoring Status: </label>
						<input id = "returnerStatus" type = "radio" value = "New" name = "returnerStatus" title = "Please indicate whether you're a returning tutor." required/> New
						&nbsp;
						<input id = "returnerStatus2" type = "radio" value = "Returning" name = "returnerStatus" required/> Returning
					</p>
					<p>
						<label for = "writingAdvisor" style = "width: 185px"> Writing Advisor Status: </label>
						<input id = "writingAdvisor" type = "radio" value = "Yes" name = "writingAdvisor" title = "Please indicate whether you're a Writing Advisor." required/> I'm a WA
						&nbsp;
						<input id = "writingAdvisor2" type = "radio" value = "No" name = "writingAdvisor" title = "Please indicate whether you're a Writing Advisor." required/> I'm not a WA
					</p>
					<p>
						<label for = "subjectTutor"> Subject Tutor: </label>
			          
			          <?php
			            // $db_file = '//home/ubuntu/myDB/afam.db';

			            // $db = new PDO('sqlite:' .$db_file)
			            // or die('Cannot connect to db');

			            // $result = $db->query('SELECT * FROM class');
			          	$subjects = array("Economics", "Biology", "Chemistry");
			          	$arrLength = count($subjects);

			            echo '<select name="subjectTutor" required>';
			            echo '<option disabled selected value> -- select an option -- </option>';

			            for($i = 0; $i < $arrLength; $i++)
			            {
			              // unset($classID, $class_name);
			              // $classID = $row['classID']; 
			              // $class_name = $row['class_name'];
			              echo '<option value="'.$subjects[$i].'">'.$subjects[$i].'</option>';
			            }
			            echo '</select>'
			          ?> 
			          
			          <br>
					</p>
					<p>
						<label for = "specialEvents"> Special events: </label>
			          
			          <?php
			            // $db_file = '//home/ubuntu/myDB/afam.db';

			            // $db = new PDO('sqlite:' .$db_file)
			            // or die('Cannot connect to db');

			            // $result = $db->query('SELECT * FROM class');
			          	$events = array("GRE Study Hour", "Students of Color Study Hour", "Thesis Hour");
			          	$arrLength = count($events);

			            echo '<select name="specialEvents" required>';
			            echo '<option disabled selected value> -- select an option -- </option>';

			            for($i = 0; $i < $arrLength; $i++)
			            {
			              // unset($classID, $class_name);
			              // $classID = $row['classID']; 
			              // $class_name = $row['class_name'];
			              echo '<option value="'.$events[$i].'">'.$events[$i].'</option>';
			            }
			            echo '</select>'
			          ?> 
			         <br>
			     </p>

			     <input type = "submit" value="Continue" style="width: 90px; margin-left:170px; margin-top: 20px"/>

				</form>
			</div>
		</div>
	</body>
</html>

<script>
	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	function showTab(n) {
	  // This function will display the specified tab of the form...
	  var x = document.getElementsByClassName("tab");
	  x[n].style.display = "block";
	  //... and fix the Previous/Next buttons:
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	  }
	  //... and run a function that will display the correct step indicator:
	  fixStepIndicator(n)
	}

	function nextPrev(n) {
	  // This function will figure out which tab to display
	  var x = document.getElementsByClassName("tab");
	  // Exit the function if any field in the current tab is invalid:
	  if (n == 1 && !validateForm()) return false;
	  // Hide the current tab:
	  x[currentTab].style.display = "none";
	  // Increase or decrease the current tab by 1:
	  currentTab = currentTab + n;
	  // if you have reached the end of the form...
	  if (currentTab >= x.length) {
	    // ... the form gets submitted:
	    document.getElementById("regForm").submit();
	    return false;
	  }
	  // Otherwise, display the correct tab:
	  showTab(currentTab);
	}

	function validateForm() {
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

	function fixStepIndicator(n) {
	  // This function removes the "active" class of all steps...
	  var i, x = document.getElementsByClassName("step");
	  for (i = 0; i < x.length; i++) {
	    x[i].className = x[i].className.replace(" active", "");
	  }
	  //... and adds the "active" class on the current step:
	  x[n].className += " active";
	}
</script>
