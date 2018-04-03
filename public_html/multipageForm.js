"use strict";
class Schedule 
{
	constructor(schedule, inputType)
	{	
		if(schedule == null)
		{
			this.schedule = Array(7).fill(null).map(x => Array(12).fill(0));	
			
		}
		else
		{
			// replace this with reading in a json file containing the open hours
			this.schedule = Object.assign([], schedule);
		}
		
		this.name = name;
	}

	toString()
	{
		var stringBuilder = "";
		
		stringBuilder += "inputType: "+this.name + "\n";

		for(var i = 0; i < this.schedule.length; i++)
		{
			stringBuilder += "\n" + this.schedule[i].toString();
		}

		return stringBuilder;
	}

	calcRatio()
	{
		// total hours available / total hours needed
	}
}
	
	/*
		Create initial schedule in AdminForm.php, pass it to multipageForm.js. After update, have nextPrev return 
		the new schedule to AdminForm.php to be stored for future use. Maybe 'chooseSchedule()' would be in AdminForm.php
	*/

	const closed = -1;
	const open = 0;
	const preferred = 1;
	const busy = 2;

	var debug = true;

	var scheduleStates;

	var currentTab = 0; // Current tab is set to be the first tab (0)
	// showTab(currentTab); // Display the current tab

	function showTab(tabIndex, isFirst = false)
	{
		if(isFirst)
		{
			scheduleStates = new Array();
			scheduleStates[0] = new Schedule(null, "0");
		}
		

		// This function will display the specified tab of the form...
		var tabs = document.getElementsByClassName("tab");
		
		tabs[tabIndex].style.display = "block";

		setIframe(tabs[tabIndex].id + "Input");

		fixButtons(tabIndex, tabs.length);
		//... and run a function that will display the correct step indicator:
		fixStepIndicator(tabIndex);
	}

	function adjustFrame(currForm, variant)
	{
		var frame = document.getElementById(currForm);
		var tabs = document.getElementsByClassName("tab");

		if(variant == 1)
		{
			frame.style.width = "880px";
			frame.style.height = "600px";	
		}
		else if(variant == -1 && (currentTab == 0 || currentTab == tabs.length - 1))
		{
			frame.style.width = "580px";
			frame.style.height = "300px";	
		}		
	}

	function print(str)
	{
		if(debug) console.log(str);
	}

	// Changes the Previous/Next buttons as necessary
	function fixButtons(tabIndex, numTabs)
	{	
		// if first tab, hide prevBtn
		if (tabIndex == 0) 
		{
	  		document.getElementById("prevBtn").style.display = "none";	
	  	}
	  	// second to last tab, button click will change the text of nextBtn from Next to Submit
	  	else if (tabIndex == (numTabs - 2)) 
		{
			document.getElementById("nextBtn").innerHTML = "Submit";
		} 
		// if last tab, hide the buttons
		else if (tabIndex == (numTabs - 1))
		{
			document.getElementById("prevBtn").style.display = "none";
			document.getElementById("nextBtn").style.display = "none";
		}
	  	else 
	  	{
	  		document.getElementById("nextBtn").innerHTML = "Next";

		  	document.getElementById("prevBtn").style.display = "inline";

		    document.getElementById("prevBtn").style  = "margin-right: 15px";
		    document.getElementById("nextBtn").style = "margin-left: 15px";
		}
	}

	// Set the src attribute of the given iFrame based upon the frameID
	function setIframe(frameID)
	{
		// use a get instead of a create to access the given iFrame and set it's src value
		var frame = document.getElementById(frameID);

		if(frame != null)
		{	
			// frame.name contains a number representing open, closed, or busy as noted above
			frame.src = "/weeklySchedule.php?sched="+JSON.stringify(scheduleStates[currentTab].schedule)+"&type="+frame.name;	
		}
	}

	// function nextPrev(currForm, variant) 
	function nextPrev(currForm, variant, sched, tab) 
	{
		print("nextPrev");
		var frame = document.getElementById('OpenHoursInput').contentWindow.document
		scheduleStates[currentTab] = new Schedule(JSON.parse(frame.getElementById("holder").value), -1);

		// This function will figure out which tab to display
		var tabs = document.getElementsByClassName("tab");

		// Exit the function if any field in the current tab is invalid:
		if (variant == 1 && !validateForm()) return false;

		// Hide the current tab:
		tabs[currentTab].style.display = "none";

		// Increase or decrease the current tab by 1:
		currentTab = currentTab + variant;

		// if you have reached the end of the form
		if (currentTab >= tabs.length-1) {

			print(tabs.length-1)
			adjustFrame(currForm, -1);
			showTab(currentTab);
			submit();

			// return false;
			return scheduleStates[currentTab-variant]
		}

		// Otherwise, display the correct tab:
		adjustFrame(currForm, variant);
		// chooseScheduleState(currentTab-variant, variant);

		if(scheduleStates[currentTab] == null)
		{
			scheduleStates[currentTab] = new Schedule(scheduleStates[currentTab-variant].schedule, 2);
		}

		showTab(currentTab);

		window.scrollTo(0, 0);

		return scheduleStates[currentTab-variant]
	}

	function validateForm() 
	{
		return true;
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
	  if (valid && !document.getElementsByClassName("step")[currentTab].className.includes(" finish"))
	  {	
  		document.getElementsByClassName("step")[currentTab].className += " finish";
	  }
	  return valid; // return the valid status
	}

	/* Changes colors of the blocks that indicate progress through the form */
	function fixStepIndicator(tabIndex) 
	{
	  // This function removes the "active" class of all steps...
	  var i, x = document.getElementsByClassName("step");

	  for (i = 0; i < x.length; i++) {
	    x[i].className = x[i].className.replace(" active", "");
	  }
	  //... and adds the "active" class on the current step:
	  if(tabIndex < x.length)
	  {
	  	if(document.getElementsByClassName("step")[currentTab].className.includes(" finish"))
	  	{
	  		x[tabIndex].className = x[tabIndex].className.replace(" finish", " active");	
	  	}
	  	else
	  	{
		  	x[tabIndex].className += " active";		  		
	  	}
	  
	  }
	  
	}

	function submit()
	{
		var fs = require("fs");

		fs.writeFile("testerFile.json", JSON.stringify(this.schedule), (err) => {
		    if (err) {
		        console.error(err);
		        return;
		    };
		    console.log("File has been created");
		});
	}