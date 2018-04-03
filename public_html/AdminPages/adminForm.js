var schedule = Array(7).fill(null).map(x => Array(12).fill(0));

function saveTimes(inputType, day, time)
{
	var closed = -1;
	var open = 0;
	var preferred = 1;
	var busy = 2;

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
			case preferred:
				timeBlock.className = "preferred-shift";
				break;
		}
	}
	else
	{
		schedule[day-1][time] = open;
		timeBlock.className = "open-shift";
	} 

	var holder = document.getElementById("holder")
	holder.value = JSON.stringify(schedule);

}