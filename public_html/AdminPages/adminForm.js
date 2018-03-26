class AdminForm
{
	// vars to use 
	const closed = -1;
	const open = 0;
	const prefered = 1;
	const busy = 2;

	var isFirst = true;

	var schedule; 

	constructor()
	{
		// replace this with reading in a json file containing the open hours
		this.schedule = Array(7).fill(null).map(x => Array(12).fill(0));

		const closed = -1;
		const open = 0;
		const prefered = 1;
		const busy = 2;
	}
	// create a 7x12 array, automatically filled with true
	// var openHours = Array(7).fill(null).map(x => Array(12).fill(0));
	
	// console.log("probs resetting the schedule to null. isFirst: "+isFirst);
	// if(isFirst)
	// {
	// 	schedule = openHours;
	// 	isFirst = false;
	// }

	getSchedule()
	{
		return schedule;
	}

	saveTimes(inputType, day, time)
	{
		// keep track of hours available
		var timeBlock = document.getElementById(day+"-"+time);

		if(timeBlock.className == "open-shift")
		{
			schedule[day-1][time] = inputType;

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
			schedule[day-1][time] = open;
			timeBlock.className = "open-shift";
		} 

	}

	// Set the src attribute of the given iFrame based upon the frameID
	setIframe(frameID)
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

	calcRatio()
	{
		// total hours available / total hours needed
	}

	submit()
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
}