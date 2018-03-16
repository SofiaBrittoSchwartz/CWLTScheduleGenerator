<script type="text/javascript">
	
	var schedule = Array(7).fill(null).map(x => Array(12).fill(0));
	schedule[2][2] = -1;
	schedule[3][3] = 2;
	schedule[4][4] = 1;

	function loadIframe()
	{
		var jsonSched = JSON.stringify(schedule);
		console.log(jsonSched);

		var frame = document.createElement("iframe");
		frame.style.width = "900px";
		frame.style.height = "600px";
		frame.style.border = "0";
		frame.src = "/weeklySchedule.php?sched="+jsonSched+"&type=2";
		document.getElementById("OpenHoursInput").appendChild(frame);
	}

</script>
<button type="button" onclick="loadIframe()">Load</button>

<div id = "OpenHoursInput">
</div>