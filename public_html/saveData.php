<?php
	$schedule = $_GET['sched'];
	$tutorList = $_GET['tutorList'];

	save($schedule, $tutorList);

	function save($schedule, $tutorList)
	{
		$input = '{ "schedule": '.$schedule.'}';

		$file = fopen("DataFiles/adminFormData1.json", "w");
		
		fwrite($file, $input); 
		fclose($file);

		$tutorFile = fopen("DataFiles/tutorList1.json", "w");
		
		fwrite($tutorFile, $tutorList);
		fclose($tutorFile);

		echo '<h1 style = "margin-top: 80px; text-align: center;"> Thank you! </h1>';
	}
	
?>