// Set the src attribute of the given iFrame based upon the frameID
function setIframe(frameID, currSchedule)
{
	print("setIframe");
	// use a get instead of a create to access the given iFrame and set it's src value
	var frame = document.getElementById(frameID);
	
	print(document.getElementsByClassName("tab"));
	print(frameID);
	print(currSchedule.getSchedule());

	if(frame != null)
	{
		// frame.name contains a number representing open, closed, or busy as noted above
		// frame.src = "/weeklySchedule.php?sched="+JSON.stringify(currSchedule.getSchedule())+"&type="+frame.name;	
		frame.src = "/weeklySchedule.php?sched="+JSON.stringify(currSchedule.getSchedule())+"&type="+frame.name;	
	}
}

function saveTimes(inputType, day, time)
{
	var closed = -1;
	var open = 0;
	var prefered = 1;
	var busy = 2;

	// keep track of hours available
	var timeBlock = document.getElementById(day+"-"+time);

	if(timeBlock.className == "open-shift")
	{
		// currSchedule.getSchedule()[day-1][time] = inputType;

		// var sched, currTab = getCurrSchedule();
		save(inputType, day, time);

		// print("update");
		// updateSchedule(scheduleStates[currentTab], currentTab);

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
		// currSchedule.getSchedule()[day-1][time] = open;
		scheduleStates[currentTab].getSchedule()[day-1][time] = open;
		timeBlock.className = "open-shift";
	} 

	// console.log(currSchedule.getSchedule());
	// testScheduleSave();
}