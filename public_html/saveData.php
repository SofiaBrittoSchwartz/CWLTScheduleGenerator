<?php
	$schedule = $_GET['sched'];
	$tutorList = $_GET['tutorList'];

	save($schedule, $tutorList);

	function save($schedule, $tutorList)
	{
		$sched = "";
		$schedule = json_decode($schedule);

		$sched .= "\n\t\t[".json_encode($schedule[0]);
		for($i = 1; $i < count($schedule); $i++):
			$sched .= ",\n\t\t".json_encode($schedule[$i]);
		endfor;

		$input = "{ \n\t\"schedule\": ".$sched."]\n}";
		$file = fopen("DataFiles/adminFormData1.json", "w");
		
		fwrite($file, $input); 
		fclose($file);

		// to get it to format properly in the file for readability
		$tutorList = json_encode(json_decode($tutorList), JSON_PRETTY_PRINT);
		$tutorFile = fopen("DataFiles/tutorList1.json", "w");
		
		fwrite($tutorFile, $tutorList);
		fclose($tutorFile);

		echo '<h1 style = "margin-top: 80px; text-align: center;"> Thank you! </h1>';
	}
	
?>