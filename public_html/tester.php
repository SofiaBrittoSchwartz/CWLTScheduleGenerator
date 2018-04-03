<body>

	<iframe id = "scheduleInput" name = "2" frameborder= "0"> </iframe>

	<button type="button" onclick="loadIframe()">Load</button>
	<button type="button" onclick="switchFrame2()">Next</button>

</body>
<script type="text/javascript">
	
	var schedule = Array(7).fill(null).map(x => Array(12).fill(0));
	schedule[2][2] = -1;
	schedule[3][3] = 2;
	schedule[4][4] = 1;

	function loadIframe()
	{
		var jsonSched = JSON.stringify(schedule);
		console.log(jsonSched);

		var frame = document.getElementById("scheduleInput");
		
		frame.style.width = "900px";
		frame.style.height = "600px";
		frame.style.border = "0";

		frame.src = "/weeklySchedule.php?sched="+jsonSched+"&type=1";
		// document.getElementById("OpenHoursInput").appendChild(frame);
	}

	function switchFrame2()
	{
		var inputType = 2;
		// var sched = document.getElementById("schedule");
		var sched = document.getElementById("scheduleInput").contentDocument;

		for(var hour = 0; hour < 12; hour++)
		{
			for(var day = 1; day < 7; day++)
			{
				var shiftBlock = sched.getElementById(day+"-"+hour);
				// var shiftBlock = sched.getElementById(day+"-"+time);

				if(shiftBlock.className == "open-shift")
				{
					shiftBlock.onclick = "saveTimes("+inputType+", "+day+", "+hour+")";
				}
				else
				{
					shiftBlock.onclick = "";
				}
			}
		}

	}

</script>
<script src="../multipageForm.js"></script>
<!-- <button type="button" onclick="tester()">Load</button> -->

<div id = "OpenHoursInput">
</div>