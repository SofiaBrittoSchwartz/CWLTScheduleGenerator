"use strict";
class Schedule 
{
	constructor(schedule, inputType)
	{	
		if(schedule == null)
		{
			this.schedule = defaultSched;	
		}
		else
		{
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

var defaultSched;
var defaultData;

var debug = true;

var scheduleStates;

var currentTab = 0; // Current tab is set to be the first tab (0)
var currentFrame = 0;

function showTab(tabIndex, isFirst = false)
{
	print("showTab");
	// This function will display the specified tab of the form...
	var tabs = document.getElementsByClassName("tab");
	tabs[tabIndex].style.display = "block";

	if(isFirst)
	{
		scheduleStates = new Array();
		defaultData = new Map();

		readTextFile('../DataFiles/adminFormData1.json');

		var input = getInputType();

		//in the case of only a single schedule iFrame, this will create a new schedule to use 
		if(input != null)
		{
			scheduleStates[0] = new Schedule(null, input);	
		}
	}
	
	setIframe(tabs[tabIndex].id);

	fixButtons(tabIndex, tabs.length);
	//... and run a function that will display the correct step indicator:
	fixStepIndicator(tabIndex);
	
}

function nextPrev(currForm, variant) 
{
	print("----------------nextPrev---------------");
	// This function will figure out which tab to display
	var tabs = document.getElementsByClassName("tab");

	updateSchedule(variant);
	// Exit the function if any field in the current tab is invalid:
	// if (variant == 1 && !validateForm()) return false;

	// Hide the current tab:
	tabs[currentTab].style.display = "none";

	// Increase or decrease the current tab by 1:
	currentTab += variant;

	// Otherwise, display the correct tab:
	// adjustFrame(currForm, variant);

	// if this tab has an Iframe for a schedule, but that schedule hasn't been instantiated yet
	if(scheduleStates[currentFrame] == null)
	{	
		var input = getInputType();
		
		if(input != null)
		{
			if(scheduleStates.length == 0)
			{
				scheduleStates[0] = new Schedule(null, input);	
			}
			else
			{
				scheduleStates[currentFrame] = new Schedule(scheduleStates[currentFrame-variant].schedule, input);	
			}
		}
	}

	showTab(currentTab);

	window.scrollTo(0, 0);
}

// Set the src attribute of the given iFrame based upon the frameID
function setIframe(frameID)
{
	print("setIframe");

	var tabType = getTabType();

	var frame = getCurrFrame();

	if(frame != null)
	{
		switch(tabType)
		{
			case "schedule":
				frame.src = "/weeklySchedule.php?sched="+JSON.stringify(scheduleStates[currentFrame].schedule, null, '\t')+"&type="+frame.name;
				break;
			case "confirmation":
				frame.src = "../saveData.php?sched="+JSON.stringify(scheduleStates[0].schedule, null, '\t')+"&tutorList="+JSON.stringify(defaultData, null, '\t');
				break;
		}
	}
}

function getCurrFrame()
{
	var tabID = document.getElementsByClassName("tab")[currentTab].id;

	var frames = document.getElementsByTagName('iframe');

	for(var i = 0; i < frames.length; i++)
	{
		if(frames[i].id.includes(tabID))
		{
			return frames[i];
		}
	}

	return null;
}

function getTabType()
{
	print("getTabType");

	var frame = getCurrFrame();

	if(frame == null)
	{
		return null;
	}

	if(frame.id.includes('Input'))
	{
		return "schedule";
	}
	else if(frame.id.includes('Screen'))
	{
		return "confirmation";
	}
	else
	{
		return "data";
	}
}

function getInputType()
{
	print("getInputType");

	// get the current tab's id to determine the frameID, 
	// then use that to access the name attribute which stores the input type in a String
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

function updateSchedule(variant)
{
	print("updateSchedule");
	// var frameID = document.getElementsByTagName("iframe")[currentTab].id;
	var frame = getCurrFrame();
	
	if(frame == null) return;
	var frameID = frame.id;

	// will exit this function if currentTab doesn't have an iFrame
	// if(document.getElementById(frameID) == null) return;

	var frameDoc = document.getElementById(frameID).contentWindow.document;
	var tabType = getTabType();

	// get updated schedule from the hidden h6 tag and save in scheduleStates
	if(tabType == "schedule" && scheduleStates[currentFrame] != null)
	{
		scheduleStates[currentFrame].schedule = JSON.parse(frameDoc.getElementById("holder").value);

		// if necessary update the subsequent scheduleStates that rely upon the current scheduleState
		if(variant == 1 && scheduleStates[currentFrame+1] != null)
		{
			scheduleStates[currentFrame+1].update(scheduleStates[currentFrame]);
		}
	}
	else if(tabType == "data")
	{
		print(frameDoc.getElementById("holder").value);
		defaultData = JSON.parse(frameDoc.getElementById("holder").value);
	}

	currentFrame += variant;
}

// Changes the Previous/Next buttons as necessary
function fixButtons(tabIndex, numTabs)
{	
	print("fixButtons");
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

/* Changes colors of the blocks that indicate progress through the form */
function fixStepIndicator(tabIndex) 
{
	// This function removes the "active" class of all steps...
	var i, x = document.getElementsByClassName("step");

	for (i = 0; i < x.length; i++) 
	{
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

// needs to be fixed / might no longer be necessary
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
	// Copied from https://stackoverflow.com/questions/14446447/how-to-read-a-local-text-file

    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                var text = JSON.parse(allText);
                defaultSched = text.schedule;
                defaultData = text.data;
            }
        }
    }
    rawFile.send(null);
}

function print(str)
{
	if(debug) console.log(str);
}