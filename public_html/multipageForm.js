"use strict";
class AdminForm 
{
	constructor(otherForm = null, name = "...")
	{	
		if(otherForm != null)
		{
			print("New Form - copying: \n" + otherForm.toString());
			this.schedule = copy(otherForm.schedule);
		}
		else
		{
			// replace this with reading in a json file containing the open hours
			this.schedule = Array(7).fill(null).map(x => Array(12).fill(0));	
		}
		
		this.name = name;
	}

	getSchedule()
	{
		return this.schedule;
	}

	setValue(day, time, value)
	{
		this.schedule[day][time] = value;
	}

	toString()
	{
		var stringBuilder = "";
		
		stringBuilder += "name: "+this.name + "\n";

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

	submit()
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
}
	
	/*
		Create initial schedule in AdminForm.php, pass it to multipageForm.js. After update, have nextPrev return 
		the new schedule to AdminForm.php to be stored for future use. Maybe 'chooseSchedule()' would be in AdminForm.php
	*/

	const closed = -1;
	const open = 0;
	const prefered = 1;
	const busy = 2;

	var debug = true;

	var scheduleStates = new Array();
	scheduleStates[0] = new AdminForm(null, "0");

	var currSchedule = scheduleStates[0];

	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	var numCopies = 0;

	function getCurrSchedule()
	{
		return currSchedule, currentTab;
		// return scheduleStates[currentTab].getSchedule();
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

	function showTab(tabIndex)
	{
		debug = true;
		print("showTab");
		

		// This function will display the specified tab of the form...
		var tabs = document.getElementsByClassName("tab");
		
		print(tabs);
		// print("...");
		tabs[tabIndex].style.display = "block";
		// tabs[currentTab].style.display = "block";

		setIframe(tabs[tabIndex].id + "Input", scheduleStates[currentTab]);
		fixButtons(tabIndex, tabs.length);
		//... and run a function that will display the correct step indicator:
		fixStepIndicator(tabIndex);
	}

	// be aware of when this is called in relation to updates of currTab
		// function chooseScheduleState(tabIndex, variant)
		// {
		// 	debug = true;
		// 	print("chooseScheduleState");
		// 	print(scheduleStates)

		// 	// print('========================================');
		// 	// print('........................................');
		// 	// print(scheduleStates)
		// 	// print(currSchedule.toString());
		// 	// print('........................................');
		// 	// print("tabIndex: "+tabIndex);
		// 	// if moving forward
		// 	if(variant == 1)
		// 	{
		// 		if(scheduleStates[tabIndex] == null)
		// 		{
		// 			print("state "+tabIndex+ " is null");
		// 			// if(tabIndex != 0)
		// 			// {
		// 			// 	scheduleStates[tabIndex] = currSchedule;	
		// 			// }
		// 			// currSchedule = new AdminForm(currSchedule, (tabIndex+1).toString());
		// 			scheduleStates[tabIndex] = new AdminForm(scheduleStates[tabIndex], (tabIndex+1).toString());
		// 			// scheduleStates.splice(tabIndex-variant, 1, currSchedule); //should I do this now or after values have been added?
		// 		}
		// 		else
		// 		{
		// 			print('save at index: '+tabIndex);
		// 			// print(currSchedule.toString());

		// 			// scheduleStates[tabIndex] = currSchedule;
		// 			// currSchedule = scheduleStates[tabIndex+variant];

		// 			//figure out a new state by comparing the new sched#1 and the old sched #2. If new sched#1 overlaps sched#2, then make appropriate changes(making new state and replacing old sched#2) and show a warning message
		// 		}
		// 	}
		// 	// if moving back
		// 	else if(variant == -1)
		// 	{
		// 		print('variant = -1\n\n');
		// 		print('index: ' +(variant + tabIndex));
		// 		print(scheduleStates.toString());
		// 		// print(currSchedule.toString());

		// 		// scheduleStates[tabIndex] = currSchedule;
		// 		// currSchedule = scheduleStates[tabIndex+variant];
		// 	}
		// 	debug = false;
		// }
	
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

	// function nextPrev(currForm, variant) 
	function nextPrev(currForm, variant, sched, tab) 
	{
		print("nextPrev");

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
			scheduleStates[currentTab] = new AdminForm(scheduleStates[currentTab-variant], (currentTab).toString());
			print(scheduleStates)
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

	// function switchFrame()
	// {
	// 	var inputType = 2;
		
	// 	var sched = document.getElementById("OpenHoursInput").contentDocument;
	// 	// .contentWindow.document.body.innerHTML;

	// 	document.getElementById("scheduleTitle").innerHTML = "Confirm Special Events";
		
	// 	// console.log(document.getElementById());

	// 	for(var hour = 0; hour < 12; hour++)
	// 	{
	// 		for(var day = 1; day < 7; day++)
	// 		{
	// 			var shiftBlock = sched.getElementById(day+"-"+hour);

	// 			// var shiftBlock = sched.getElementById(day+"-"+time);

	// 			if(shiftBlock.className == "open-shift")
	// 			{
	// 				print('inputType: '+inputType);
	// 				shiftBlock.onclick = "saveTimes("+inputType+", "+day+", "+hour+")";
	// 			}
	// 			else
	// 			{
	// 				shiftBlock.onclick = "";
	// 			}
	// 		}
	// 	}

	// }

	function copy(arr) 
	{
		numCopies++;

		var output, v, key;

		output = Array.isArray(arr) ? [] : {};
		
		for (key in arr) 
		{
		   v = arr[key];
		   output[key] = (typeof v === "object") ? copy(v) : v;
		}

		return output;
	}