class AdminForm 
{
	constructor(otherForm = null, name = "...")
	{	
		if(otherForm != null)
		{
			this.schedule = copy(otherForm.schedule);
		}
		else
		{
			// replace this with reading in a json file containing the open hours
			this.schedule = Array(7).fill(null).map(x => Array(12).fill(0));	
		}
		
		this.name = name;
		console.log("name: "+this.name);

		// vars to use 
		const closed = -1;
		const open = 0;
		const prefered = 1;
		const busy = 2;
	}

	getSchedule()
	{
		return this.schedule;
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

	const closed = -1;
	const open = 0;
	const prefered = 1;
	const busy = 2;

	const debug = true;

	var scheduleStates = new Array();
	print("first");
	var currSchedule = new AdminForm(null, "first");

	scheduleStates.push(currSchedule);

	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	var numCopies = 0;

	function newSchedules()
	{
		
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

	function tester()
	{
		var firstState = new AdminForm(null, "firstState");
		firstState.getSchedule()[0][2] = 2;
		firstState.getSchedule()[1][2] = 2;
		firstState.getSchedule()[2][2] = 2;

		var secondState = new AdminForm(firstState, "secondState");
		secondState.getSchedule()[3][3] = -1;

		console.log(firstState.toString());
		console.log(secondState.toString());
	}

	function showTab(tabIndex)
	{
	  // This function will display the specified tab of the form...
	  var tabs = document.getElementsByClassName("tab");
	  tabs[tabIndex].style.display = "block";
	  
	  // console.log("showTab - scheduleStates[currentTab]: \n"+scheduleStates[currentTab]);
	  
		  	// if first page
		  	// if(scheduleStates[currentTab] != null)
		  	// {
		  	// 	console.log("currSchedule wasn't null. It was:" +scheduleStates[currentTab]);
		  		
		  	// 	// replaces the previous schedule stored at that index with the new information, 
		  	// 	// in case modifications have been made upon returning to this page
			  // 	scheduleStates.splice(currentTab, 1, currSchedule);
			  // 	currSchedule = scheduleStates[tabIndex];

			  // 	console.log("Schedule States: \n"+scheduleStates);
		  	// }
		  	
		  	// else
		    // store or update the schedule
		  	// if(scheduleStates[currentTab] == null)
		  	// {
		  	// 	console.log("is null and not on first tab");

		  	// 	console.log("showTab - currSchedule: \n"+currSchedule);
		  	// 	// store the currSchedule for purposes of backtracking through the form
			  // 	scheduleStates.splice(currentTab, 0, currSchedule);
			  // 	currSchedule = new AdminForm(currSchedule);
			  // 	console.log("Schedule States: \n"+currSchedule);
		  	// }

	  //sets iframe source if iframe isn't null
	  setIframe(tabs[tabIndex].id + "Input");

	  fixButtons(tabIndex, tabs.length);
	  //... and run a function that will display the correct step indicator:
	  fixStepIndicator(tabIndex);
	}

	// be aware of when this is called in relation to updates of currTab
	function chooseScheduleState(tabIndex, variant)
	{
		print("tabIndex: "+tabIndex);
		// if moving forward
		if(variant == 1)
		{
			if(scheduleStates[tabIndex] == null)
			{
				print("state "+tabIndex+ " is null");
				currSchedule = new AdminForm(currSchedule, (tabIndex+variant).toString());
				// scheduleStates.splice(tabIndex-variant, 1, currSchedule); //should I do this now or after values have been added?
			}
			else
			{

				// scheduleStates.splice(tabIndex-variant, 1, currSchedule);
				currSchedule = scheduleStates[tabIndex];

				//figure out a new state by comparing the new sched#1 and the old sched #2. If new sched#1 overlaps sched#2, then make appropriate changes(making new state and replacing old sched#2) and show a warning message
			}
		}
		// if moving back
		else if(variant == -1)
		{
			// scheduleStates.splice(tabIndex-variant, 1, currSchedule);
			currSchedule = scheduleStates[tabIndex];
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
			frame.src = "/weeklySchedule.php?sched="+JSON.stringify(currSchedule.getSchedule())+"&type="+frame.name;	
		}
	}

	function saveTimes(inputType, day, time)
	{
		// keep track of hours available
		var timeBlock = document.getElementById(day+"-"+time);

		if(timeBlock.className == "open-shift")
		{
			currSchedule.getSchedule()[day-1][time] = inputType;

			switch(inputType)
			{
				case closed:
					timeBlock.className = "closed-shift";
					break;
				case busy:
					timeBlock.className = "busy-shift";
					break;
				case prefered:
					timeBlock.className = "prefered-shift";
					break;
			}
		}
		else
		{
			currSchedule.getSchedule()[day-1][time] = open;
			timeBlock.className = "open-shift";
		} 

		// console.log(currSchedule.getSchedule());
	}

	function nextPrev(currForm, variant) 
	{
		print("nextPrev");
		
		// storeSchedule(currForm, currSchedule);

		// This function will figure out which tab to display
		var tabs = document.getElementsByClassName("tab");

		// Exit the function if any field in the current tab is invalid:
		if (variant == 1 && !validateForm()) return false;

		// Hide the current tab:
		tabs[currentTab].style.display = "none";

		print(currSchedule.toString());
		scheduleStates.set(currentTab, currSchedule);

		// Increase or decrease the current tab by 1:
		currentTab = currentTab + variant;

		// if you have reached the end of the form...
		if (currentTab >= tabs.length-1) {

			adjustFrame(currForm, -1);
			
			showTab(currentTab);

			// ... the form gets submitted:
			submit();

			return false;
		}

		// Otherwise, display the correct tab:
		adjustFrame(currForm, variant);
		chooseScheduleState(currentTab, variant);
		showTab(currentTab);

		window.scrollTo(0, 0);
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