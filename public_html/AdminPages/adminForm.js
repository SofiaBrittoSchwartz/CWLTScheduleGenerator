// create a 7x12 array, automatically filled with true
var openHours = Array(7).fill(null).map(x => Array(12).fill(0));

// vars to use 
const closed = -1;
const open = 0;
const busy = 2;

var isFirst = true;

var schedule; 

if(isFirst)
{
	schedule = openHours;
	isFirst = false;
}

function getSchedule()
{
	return schedule;
}

function saveTimes(inputType, day, time)
{
	console.log("Javascript saveTimes()");
	// keep track of hours available
	var timeBlock = document.getElementById(day+"-"+time);

	if(!timeBlock.className.includes("-head"))
	{
	  schedule[day-1][time] = inputType;
	  timeBlock.className += "-head";
	}
	else
	{
	  schedule[day-1][time] = open;
	  timeBlock.className = timeBlock.className.replace("-head", "");
	} 

}

// Set the src attribute of the given iFrame based upon the frameID
function setIframe(frameID)
{
	console.log("setIframe: "+schedule);
	// use a get instead of a create to access the given iFrame and set it's src value
	var frame = document.getElementById(frameID);

	if(frame != null)
	{	
		console.log(schedule);
		console.log(frame.name);
		// frame.name contains a number representing open, closed, or busy as noted above
		frame.src = "/weeklySchedule.php?sched="+JSON.stringify(schedule)+"&type="+frame.name;	
	}
}

function calcRatio()
{
	// total hours available / total hours needed
}

function submit()
{
	var fs = require("fs");

	fs.writeFile("testerFile.json", JSON.stringify(schedule), (err) => {
	    if (err) {
	        console.error(err);
	        return;
	    };
	    console.log("File has been created");
	});
}