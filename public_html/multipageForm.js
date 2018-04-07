"use strict";
class Schedule 
{
	constructor(schedule, inputType)
	{	
		if(schedule == null)
		{
			console.log("constructor");
			// this.schedule = Array(6).fill(null).map(x => Array(12).fill(0));	
			this.schedule = defaultSched.schedule;
			
		}
		else
		{
			// replace this with reading in a json file containing the open hours
			this.schedule = Object.assign([], schedule);
		}
		
		this.inputType = inputType;
	}

	update(prev)
	{
		for(var i = 0; i < this.schedule.length; i++)
		{
			for(var j = 0; j < this.schedule[0].length; j++)
			{
				if(prev.schedule[i][j] == prev.inputType && this.schedule[i][j] != prev.inputType)
				{
					this.schedule[i][j] = prev.inputType;
				}
			}
		}
	}

	calcRatio()
	{
		// total hours available / total hours needed
	}

	toString()
	{
		var stringBuilder = "";
		
		stringBuilder += "inputType: "+this.inputType + "\n";

		for(var i = 0; i < this.schedule.length; i++)
		{
			stringBuilder += "\n" + this.schedule[i].toString();
		}

		return stringBuilder;
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

var defaultSched = null;
readTextFile('../DataFiles/adminFormData.json');

var debug = true;

var scheduleStates;

var currentTab = 0; // Current tab is set to be the first tab (0)
// showTab(currentTab); // Display the current tab

function showTab(tabIndex, isFirst = false)
{
	// This function will display the specified tab of the form...
	var tabs = document.getElementsByClassName("tab");
	
	tabs[tabIndex].style.display = "block";

	if(isFirst)
	{
		scheduleStates = new Array();

		var input = getInputType();

		if(input != null)
		{
			scheduleStates[0] = new Schedule(null, input);	
		}
	}

	setIframe(tabs[tabIndex].id + "Input");

	fixButtons(tabIndex, tabs.length);
	//... and run a function that will display the correct step indicator:
	fixStepIndicator(tabIndex);
}

function nextPrev(currForm, variant) 
{
	// This function will figure out which tab to display
	var tabs = document.getElementsByClassName("tab");

	updateSchedule(tabs[currentTab].id + "Input", variant);

	// Exit the function if any field in the current tab is invalid:
	if (variant == 1 && !validateForm()) return false;

	// Hide the current tab:
	tabs[currentTab].style.display = "none";

	// Increase or decrease the current tab by 1:
	currentTab = currentTab + variant;

	// if you have reached the end of the form
	if (currentTab >= tabs.length-1) 
	{
		print(tabs.length-1)
		// adjustFrame(currForm, -1);
		showTab(currentTab);
		submit(currForm);
		return;
	}

	// Otherwise, display the correct tab:
	// adjustFrame(currForm, variant);

	// if this tab has an Iframe for a schedule, but that schedule hasn't been instantiated yet
	if(scheduleStates[currentTab] == null)
	{	
		var input = getInputType();

		if(input != null)
		{
			scheduleStates[currentTab] = new Schedule(scheduleStates[currentTab-variant].schedule, input);	
		}
	}

	showTab(currentTab);

	window.scrollTo(0, 0);
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

function updateSchedule(frameID, variant)
{
	// will exit this function if currentTab doesn't have a weeklySchedule iFrame
	if(document.getElementById(frameID) == null) return;

	var newSched = document.getElementById(frameID).contentWindow.document;

	// get updated schedule from the hidden h6 tag and save in scheduleStates
	if(scheduleStates[currentTab] != null)
	{
		scheduleStates[currentTab].schedule = JSON.parse(newSched.getElementById("holder").value);
	}

	// if necessary update the subsequent scheduleStates that rely upon the current scheduleState
	if(variant == 1 && scheduleStates[currentTab+1] != null)
	{
		scheduleStates[currentTab+1].update(scheduleStates[currentTab]);
	}
}

function getInputType()
{
	var tabID = document.getElementsByClassName("tab")[currentTab].id;
	var frame = document.getElementById(tabID + "Input");
	
	if(frame != null)
	{
		return parseInt(frame.name);	
	}
	else
	{
		return null;
	}
}

// needs to be fixed
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
		// document.getElementById("nextBtn").onclick = '<?php $file = fopen("adminFormData.json", "w"); $fwrite($file, "Hello"); fclose($file);?>';
		// document.getElementById("nextBtn").innerHTML = "Submit";
		
		// <input type="submit" id="submit" visibility = "hidden"></input>
		print("FIXBUTTONS");
		console.log(scheduleStates[1].schedule);
		console.log(JSON.stringify(scheduleStates[1].schedule));

		var holder = "hello there";
		// "/weeklySchedule.php?sched="+JSON.stringify(scheduleStates[currentTab].schedule)+"&type="+frame.name;	
		// document.getElementById("adminForm").action = "../saveData.php?sched="+JSON.stringify(scheduleStates[1].schedule);
		document.getElementById("adminForm").action = "../saveData.php?data="+holder;

		var submitBtn = document.createElement('input');
		submitBtn.type = 'submit';
		submitBtn.display = 'inline';
		document.getElementById('btnHolder').append(submitBtn);
		
		document.getElementById("nextBtn").style.display = "none";
	} 
	// if last tab, hide the buttons
	else if (tabIndex == (numTabs - 1))
	{
		document.getElementById("prevBtn").style.display = "none";
		document.getElementById("nextBtn").style.display = "none";
	}
  	else 
  	{
  		// document.getElementById("nextBtn").innerHTML = "Next";

	  	document.getElementById("prevBtn").style.display = "inline";

	    document.getElementById("prevBtn").style  = "margin-right: 15px";
	    document.getElementById("nextBtn").style = "margin-left: 15px";
	}
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

/* NO LONGER SURE IF NECESSARY OR EFFECTIVE */
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
  if (valid && !document.getElementsByClassName("step")[currentTab].className.includes(" finish"))
  {	
		document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function readTextFile(file)
{
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                // alert(allText);
                defaultSched = JSON.parse(allText);
                print(defaultSched);
            }
        }
    }
    rawFile.send(null);
}

function print(str)
{
	if(debug) console.log(str);
}